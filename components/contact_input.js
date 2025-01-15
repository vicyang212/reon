export default{
    template:`
    <div class="row mb-3 input-group input-group-sm">
      <input 
        class="form-control" 
        :type="type"
        :name="name"
        :id="id"
        :placeholder="placeholder"
        required
      >
    </div>
    `,
    props:{
        type:String,
        name:String,
        id:String,
        placeholder:String
    }
}