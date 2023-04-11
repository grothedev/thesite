export default {
    template: `
        <form v-on:submit.prevent="addTask" class = "small">
            <input type = "text" v-model="inputTask"></input>
            <button type = "submit" class = "small">Add Task</button>
        </form>`,
    props: {
        tasks: Array
    },
    data(){
        return {
            inputTask: ''
        }
    },
    methods: {
        addTask(){
            //emit an event, which has the name of a function in the cmpnt that has listener
            this.$emit('add-task', this.inputTask);
            this.inputTask = '';
        }
    }
}