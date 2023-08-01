import util from "./util.js";

export default {
    data() {
        return {
            uploadState: {
                files: [], //filename, sessionid, percent
                //sessions: new Map(), //sessionID -> file upload status
            },
            sessions: new Map(),
            progressText: "",
            percent: 0
        };
    },
    props: {
        env: []
    },
    methods: {
        updateProgress(sessionID, chunkID, percent){
            //this.sessions.get(sessionID).percent = percent;
            //this.sessions[sessionID].percent = percent;
            let fs = this.uploadState.files.find((f)=> f['sessionID'] == sessionID);
            console.log(fs);
            fs.percent = percent;
            console.log(this.uploadState.files);
        },
        startUploading(postDataList, chunkIndex, fileIndex){
            $.ajax({
                url: this.env['FILEUPLOAD_URL'],
                type: 'POST',
                data: postDataList[chunkIndex],
                processData: false,
                contentType: false,
                success: (res) => { //TODO send next chunk in the callback, because there's no reason to confuse things by having multiple TCP streams going
                    if (res['success']){
                        //this.updateProgress(res['session_id'], res['chunk_id'], res['percent']);
                        if (chunkIndex == postDataList.length-1){
                            console.log('file uploaded');
                        } else {
                            this.startUploading(postDataList, chunkIndex+1);
                        }
                    } else { //retry
                        this.startUploading(postDataList, chunkIndex);
                    }
                    if (postDataList.length == 1){
                        this.percent = "100";
                        this.uploadState.files[fileIndex]['percent'] = 100;
                    } else {
                        this.percent = (100 * (chunkIndex / (postDataList.length-1))).toString();
                        this.uploadState.files[fileIndex]['percent'] = (100 * (chunkIndex / (postDataList.length-1)));
                    }
                    console.log(this.percent);
                    
                    //this.updateProgress(res['session_id'], res['chunk_id'], percent);
                    this.progressText = this.percent.toString();
                },
                error: function(info){
                    //TODO retry?
                    console.log(info);
                }
            });
        },
        uploadFile(){
            $.support.cors = true;
            for (let f of $('#f')[0].files){
                if (f.size > this.env['FILEUPLOAD_MAX_MB']*1024*1024){
                    console.log(`file ${f.name} too big`);
                    alert(`Maximum upload size is ${this.env['FILEUPLOAD_MAX_MB']} MB. ${f.name} will not upload`);
                    continue;
                }
                const chunkSize = this.env['FILEUPLOAD_CHUNK_MB']*1024*1024; //convert megabyte to byte
                const numChunksToUpload = Math.ceil(f.size / chunkSize);
                var postDataList = new Array(); //list of FormData, each element for a chunk
                var c = 0; //current chunk
                //keep track of which chunks were successfully uploaded. experimenting with 2 different implementations
                var chunkUploadSuccess = new Array(numChunksToUpload).fill(false); //for each index, success or failure
                var chunksUploaded = new Array(); //a list of only the successful chunks

                var errored = false;
                const sessionID = util.hashcode(f.name+Date.now().toString());

                this.uploadState.files.push({
                    'name': f.name,
                    'sessionID': sessionID,
                    'percent': 0
                });
                this.sessions.set(sessionID, {
                            'name': f.name,
                            'percent': 0
                });
                let fileIndex = this.uploadState.files.length-1; //for the progress UI. this is really not ideal. i need to figure out why maps aren't working

                console.log(`beginning upload. ${numChunksToUpload} chunks, each ${chunkSize} bytes. total ${f.size}`);            

                //async upload each chunk
                for (c = 0; c < numChunksToUpload; c++){
                    const h = c * chunkSize; //start
                    const t = Math.min(h+chunkSize, f.size);
                    //don't need to wait for previous chunk to finish uploading, because server will be able to handle
                    const chunk = f.slice(h, t);
                    const formData = new FormData();

                    formData.append('session_id', sessionID);
                    formData.append('chunked', true);
                    formData.append('file_chunk', chunk);
                    formData.append('chunk_id', c);
                    formData.append('total_chunks', numChunksToUpload);
                    formData.append('filename', f.name);

                    postDataList.push(formData);
                }

                //now we have each of the chunks of the file as an object, so upload them one after the other
                this.startUploading(postDataList, 0, fileIndex);
            }
        },
        testhash(e){
            let text = e.srcElement.value;
            console.log(text + ": " + util.hashcode(text));
        },
        prepareFileInput(){
            console.log('preparing '+$('#f')[0].files.length+' files');
            this.sessions.clear();
            this.uploadState.files = [];
            for (let f of $('#f')[0].files){
                console.log(f);
                if (f.size > this.env['FILEUPLOAD_MAX_MB']*1024*1024){
                    console.log(`file ${f.name} too big`);
                    alert(`Maximum upload size is ${this.env['FILEUPLOAD_MAX_MB']} MB. ${f.name} will not upload`);
                    continue;
                }
            }
            //TODO some more UI meta info here
            addFilesToUploadState($('#f')[0]);
        },
        //translate form data files into the datastructure for this application
        addFilesToUploadState(files){
            for (let f of files){
                this.uploadState.files.push({
                    'name': f.name,
                    'sessionID': sessionID,
                    'percent': 0
                });
            }
        }
    },
    components: {
        'upload-status': {
            template: `
                <li v-for="file in files">
                    {{file.name}} : {{file.percent}}
                </li>`,
            props: {
                files: [],
            }
        }
    },
    computed: { //computed properties: functions called when they're needed in DOM
    },

    //LIFECYCLE HOOKS
    created(){
    },
    mounted(){
        //this.uploadState.sessions = new Map();
    }
};

