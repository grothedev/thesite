<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-default.min.css"/> 
<link rel="stylesheet" href="css/style.css" />
<script src = "https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src = "js/util.js" ></script>
<!-- <script src = "https://cdn.tailwindcss.com"></script> -->
<script src = "https://unpkg.com/vue@3"></script>
<script type="module">
    import App from "./js/GardenApp.js";
    Vue.createApp(App).mount('#app');
</script>
</head>
<html>
<h2>Community Garden test page</h2>
<body>
<div id = "app" class = "container" >
    <div class = "row">
        <div class = "card col-sm-6">
            current tasks
            <model-list :tasks="tasks"><!-- vue cmpnt that shows a list of a list of some model. hopefully i can customize what it uses for the cmpnt to use for each item -->
            </model-list>
            <!--<form-add-task :tasks="tasks" />--><!-- pass in props to update the parent state -->
            <!-- '@' = 'v-on:' ; map the event name to the function to call-->
            <form-add-task2 @add-task="addTask" /><!-- alternate way of dealing with parent state -->
            <pre>

                @{{ tasks }}
            </pre>
        </div>
        <div class = "card col-sm-6">
            current projects
        </div>
    </div>
    <div class = "card">
        suggest a project:
        <!-- v-model binds the value of this input to the given vue variable -->
        <input type = "text" v-model="inputSuggestion">
        <!-- bind attribute 'class' to the vue value htmlClasses.button -->
        <!-- shorthand is just ':' -->
        <button id = "btnSuggestion" :class="htmlClasses.button" v-on:click="btnSubmitSuggest">Submit</button>
        <br>
        <p> @{{ suggestions }} </p>
    </div>
    <div class = "card">
        garden A info
    </div>
    <div class = "card">
        garden B info
    </div>
    <div class = "row" id = "colorthemetest">
        <!-- a slider to adjust "time of day", and some text with background color to show how theme changes -->
        <p id = "samplep">Here is the sample text. What it says I do not know. It is probably words though. Words mean things. People seem to take an interest in the matter of things. </p>
        <input width = "800px" type = "range" id = "colorslider" min="0" max="100" v-on:input="updateColor" />
    </div>
    @{{ content }}
</div>
</body>
</html>
