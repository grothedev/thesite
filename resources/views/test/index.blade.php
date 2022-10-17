<!doctype html>
<html lang="en">
    <head>
        <meta charset = "UTF-8">
        <title>vue test</title>
        <script src = "https://unpkg.com/vue@3"></script>
        
    </head>

    <body>

        <div id = "app">
            {{ greeting }}
        </div>
        <script>
            Vue.createApp({
                data(){
                    return {
                        greeting: 'yo yo yo'
                    };
                }
            }).mount('#app');
        </script>
    </body>

</html>