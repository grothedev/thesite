import ModelList from "./ModelList.js";
import FormTaskAdd from "./FormTaskAdd.js";
import FormTaskAdd2 from "./FormTaskAdd2.js";

export default {
    data() {
        return {
            needsServerPush: false, //state data has been updated locally, so need to push to server
            needsServerPull: false, //state data may be stale, re-pull
            content: 'this is main content of garden page',
            inputSuggestion: '',
            inputTask: '',
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
                
            },
            tags: [],
            colorRangeBG: [
                [0x54, 0x42, 0x32],
                [0xe9, 0xdb, 0x91]
            ],
            colorRangeText: [
                [0x9d, 0x9a, 0x66],
                [0x6f, 0x6c, 0x49]
            ]
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
        },
        addTask(label){ //this must be the same name as the 'event' emitted
            this.tasks.push({
                text: label,
                description: 'default desc',
                due: 'sometime',
                recurInterval: '8'
            }); //NOTE this is where you would use an 'action'/'reducer' to just pass in the string that would then be transformed into the proper data strcture to put into state
            this.inputTask = '';
        },
        //takes a color range and percent, returns the og color with that much brightness
        getAdjustedColor(rng, p){
            var r = (rng[0][0]);
            r = r + p * (rng[1][0]-rng[0][0]);
            var g = rng[0][1];
            g = g + p * (rng[1][1] - rng[0][1]);
            var b = rng[0][2];
            b = b + p * (rng[1][2] - rng[0][2]);
            var c = b | (g << 8) | (r << 16);
            return c.toString(16);
        },
        updateColor(c){
            //$('#samplep')[0].value = c;
            let v = c.srcElement.value;
            
            //console.log((v * .01 * parseInt('ffffff', 16)).toString(16));
            $('#samplep')[0].style.backgroundColor = '#'+this.getAdjustedColor(this.colorRangeBG, v*.01);//'#'+(v * .01 * parseInt('ffffff', 16)).toString(16);
            $('#samplep')[0].style.color = '#'+this.getAdjustedColor(this.colorRangeText, v*.01);
        }
        
    },
    components: {
        'model-list': ModelList,
        'form-add-task': FormTaskAdd,
        'form-add-task2': FormTaskAdd2
    },
    computed: { //computed properties: functions called when they're needed in DOM
    },

    //LIFECYCLE HOOKS
    created(){
        fetch('http://192.168.1.159:8090/api/tags')
            .then((res) => res.json() )
            .then((data) => data.forEach((t)=>this.tags.push(t.label)));
    },
    mounted(){
        let now = new Date();
        let p;
        if (now.getHours() < 12){
            p = (now.getHours()*60*60 + now.getMinutes() * 60 + now.getSeconds()) / (12*60*60); //percent through with first half of day
        } else {
            p = 1 - ((now.getHours()*60*60 + now.getMinutes() * 60 + now.getSeconds()) - 12*60*60) / (12*60*60); //percent through with second half of day
        }
        console.log(p);
        $('body')[0].style.backgroundColor = '#'+this.getAdjustedColor(this.colorRangeBG, p);
    }
};