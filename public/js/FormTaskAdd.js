export default {
    template: `
        <form v-on:submit.prevent="addTask" class = "small">
            <input type = "text" v-model="inputTask"></input>
            <button type = "submit" class = "small">Add Task</button>
        </form>`,
    props: {
        tasks: Array
    },
    methods: {
        addTask(e){
            //e.preventDefault();
            alert('adf');
            this.tasks.push({
                text: this.inputTask,
                description: 'default desc',
                due: 'sometime',
                recurInterval: '8'
            }); //NOTE this is where you would use an 'action'/'reducer' to just pass in the string that would then be transformed into the proper data strcture to put into state
            this.inputTask = '';
        }
    }
}