<!DOCTYPE html>
<html>
<head>
<script type="module">
    import {ModelList} from "./ModelList.js";
    let app = {
        data() {
            return {
                needsServerPush: false, //state data has been updated locally, so need to push to server
                needsServerPull: false, //state data may be stale, re-pull
                content: 'this is the main content of garden page',
                inputSuggestion: '',
                suggestions: [
                    {
                        id: 1,
                        text: 'do a thing',
                        date: '20230208'
                    },
                ],
                tasks: [
                    {
                        text: 'plant radishes',
                        description: 'in row 4-6',
                        due: '20230325',
                        //usersOfInterest: 
                    },
                    {
                        text: 'dig some holes',
                        description: 'idk',
                        due: '20230404',
                        //usersOfInterest: 
                    },
                    {
                        text: 'pull weeds',
                        description: 'careful not to pull thyme',
                        due: '20230211',
                        recurInteval: '7', //regularly recurring task, every week
                        //usersOfInterest: 
                    },
                ],
                htmlClasses: {
                    button: 'small',
                    
                }
            };
        },
        methods: {
            btnSubmitSuggest(){
                console.log(this.inputSuggestion);
                let prevID = suggestions[suggestions.length-1].id;
                this.suggestions.push({
                    id: prevID+1,
                    text: this.inputSuggestion,
                    date: 'current date',
                }); //NOTE then this would be passed to PHP
            }
        },
        computed: { //computed properties: functions called when they're needed in DOM
        },
        //called when component is mounted
        mounted(){
        }
    };

    Vue.createApp(app).mount('#app');
</script>
<link rel="stylesheet" href="https://cdn.rawgit.com/Chalarangelo/mini.css/v3.0.1/dist/mini-default.min.css"> 
<!-- <script src = "https://cdn.tailwindcss.com"></script> -->
<script src = "https://unpkg.com/vue@3"></script>
</head>
<html>
<h2>Community Garden test page</h2>
<body>
<div id = "app" class = "container" >
    <div class = "row">
        <div class = "card col-sm-6">
            current tasks
            <ul>
                <li v-for="task in tasks">
                    <!-- use :key to prevent ordering and local state getting messed up from vue's in-place patching -->
                    <label><input type = "checkbox" v-model="task.done" :key="task.id">@{{ task.text }}; @{{ task.description }}</input></label>
                </li>
            </ul><br>
            <pre>
                @{{ tasks }}
            </pre>

            <ModelList><!-- vue cmpnt that shows a list of a list of some model. hopefully i can customize what it uses for the cmpnt to use for each item -->
                slot text passed in
            </ModelList>
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
    @{{ content }}
</div>


</body>
</html>