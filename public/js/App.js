import util from "./util.js";

export default {
    data() {
        return {
            
        };
    },
    methods: {
        startUploading: function(postDataList, index){
            $.ajax({
                url: 'http://192.168.1.202:8090/api/files',
                type: 'POST',
                data: postDataList[index],
                processData: false,
                contentType: false,
                success: function(res){ //TODO send next chunk in the callback, because there's no reason to confuse things by having multiple TCP streams going
                    if (res['success']){
                        if (index == postDataList.length-1){
                            console.log('file uploaded');
                        } else {
                            startUploading(postDataList, index+1);
                        }
                    } else { //retry
                        startUploading(postDataList, index);
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
                const chunkSize = 4096;//4*1024*1024; //4MB
                const numChunksToUpload = Math.ceil(f.size / chunkSize);
                var postDataList = new Array(); //list of FormData, each element for a chunk
                var c = 0; //current chunk
                //keep track of which chunks were successfully uploaded. experimenting with 2 different implementations
                var chunkUploadSuccess = new Array(numChunksToUpload).fill(false); //for each index, success or failure
                var chunksUploaded = new Array(); //a list of only the successful chunks

                var errored = false;
                const sessionID = util.hashcode(f.filename+Date.now().toString());

                

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
        
    },
    components: {

    },
    computed: { //computed properties: functions called when they're needed in DOM
    },

    //LIFECYCLE HOOKS
    created(){
    },
    mounted(){
    }
};

function startUploading(postDataList, index){
    $.ajax({
        url: 'http://192.168.1.202:8090/api/files',
        type: 'POST',
        data: postDataList[index],
        processData: false,
        contentType: false,
        success: function(res){ //TODO send next chunk in the callback, because there's no reason to confuse things by having multiple TCP streams going
            if (res['success']){
                if (index == postDataList.length-1){
                    console.log('file uploaded');
                } else {
                    startUploading(postDataList, index+1);
                }
            } else { //retry
                startUploading(postDataList, index);
            }
            console.log(res);
        },
        error: function(info){
            //TODO retry?
            console.log(info);
        }
    });
}