export default {
    template: `
        <ul>
            <h5><slot /></h5>
            <li v-for="task in tasks">
                <label><input type = "checkbox" v-model="task.done" :key="task.id">@{{ task.text }}; @{{ task.description }}</input></label>
            </li>
        </ul>
    `, 
    data(){
    
    }
}