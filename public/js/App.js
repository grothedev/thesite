import util from "./util.js";

export default {
    data() {
        return {
            uploadState: {
                files: [], //filename -> percent
                sessions: new Map(), //sessionID -> file upload status
            },
        };
    },
    props: {
        env: []
    },
    methods: {
        updateProgress(sessionID, chunkID, percent){
            this.uploadState.sessions.get(sessionID).percent = percent;
            this.uploadState.files = this.uploadState.sessions.entries().map((k,v)=>{
                return { v };
            });
        },
        startUploading(postDataList, index){
            console.log('is this the function?');
            $.ajax({
                url: this.env['FILE_UPLOAD_URL'],
                type: 'POST',
                data: postDataList[index],
                processData: false,
                contentType: false,
                success: (res) => { //TODO send next chunk in the callback, because there's no reason to confuse things by having multiple TCP streams going
                    if (res['success']){
                        //this.updateProgress(res['session_id'], res['chunk_id'], res['percent']);
                        if (index == postDataList.length-1){
                            console.log('file uploaded');
                        } else {
                            this.startUploading(postDataList, index+1);
                        }
                    } else { //retry
                        this.startUploading(postDataList, index);
                    }
                    console.log(res);
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
                    'filename': f.name,
                    'sessionID': sessionID,
                    'percent': 0
                });
                this.uploadState.sessions.set(sessionID, {
                            'filename': f.name,
                            'percent': 0
                });

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
                this.startUploading(postDataList, 0);
            }
        },
        testhash(e){
            let text = e.srcElement.value;
            console.log(text + ": " + util.hashcode(text));
        },
        prepareFileInput(){
            console.log('preparing '+$('#f')[0].files.length+' files');
            this.uploadState.sessions.clear();
            this.uploadState.files = [];
            for (let f of $('#f')[0].files){
                console.log(f);
                const chunkSize = 1*128*1024; //4*1024*1024; //4MB
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
                this.uploadState.sessions.set(sessionID, {
                            'name': f.name,
                            'percent': 0
                });
                console.log(`file ${f.name}. ${numChunksToUpload} chunks, each ${chunkSize} bytes. total ${f.size}`);
            }
        },
    },
    components: {
        'upload-status': {
            template: `
                <li v-for="file in files">
                    {{file.name}} : {{file.percent}}
                </li>`,
            props: {
                files: []
            }
        }
    },
    computed: { //computed properties: functions called when they're needed in DOM
    },

    //LIFECYCLE HOOKS
    created(){
    },
    mounted(){
    }
};

