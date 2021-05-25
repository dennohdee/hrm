<template>
    <div class="pd-20 card-box mb-30">
        <div class="clearfix mb-20">
            <div class="pull-left">
                <h4 class="text-blue h4">User</h4>
            </div>
            <div class="pull-right">
                <!-- refresh data button -->
                <button @click.prevent="getUsers(page = 1)" class="btn btn-sm btn-round btn-outline-info" :disabled="isDisabled">
                    <div v-if="busy"><i class="fa fa-refresh fa-spin fa-fw"></i> </div>
                    <div v-else><i class="fa fa-refresh"></i> </div>
                </button>
            </div>
        </div>
        <!-- data table -->
        <div class="table-responsive">
            <div v-if="users.total == 0" class="p-3 border border-light text-center">
                Sorry! No User has been added yet.
            </div>
            <table v-else class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Photo</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Photo</th>

                    </tr>
                </tfoot>
                <div v-if="busy" class="text-center">Please wait. Loading...<i class="micon fa fa-refresh fa-spin fa-fw"></i></div>
                <tbody v-else>
                    <tr v-for="data in users.data" :key="data.id">
                        <td>{{ data.name }}</td>
                        <td>{{ data.email }}</td>
                        <td>{{ data.photo }}</td>
                        <td>
                            <button @click="setEditValue(data.id,data.name,data.email,data.photo)" class="btn btn-sm btn-round btn-outline-* btn-info text-white" title="Edit User Detail" data-toggle="modal" :data-target="'#edit'+data.id"><i class="icon-copy fa fa-edit"></i></button>
                            <button @click.prevent="deleteItem('deleteuserpath',data.id)" class="btn btn-sm btn-round btn-outline-* btn-danger" title="Delete"><i class="icon-copy fa fa-trash-o"></i></button>
                        </td>
                        <!-- edit modal -->
                        <div class="modal fade" :id="'edit'+data.id" tabindex="-1" role="dialog" aria-labelledby="myMediumModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myMediumModalLabel">Edit User Details[ {{ data.name }}]</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <form method="POST" @submit.prevent="submit('edit')">
                                        <div class="modal-body row">
                                            <div class="form-group col-md-12">
                                            <label> Name</label>
                                            <input class="form-control" name="name" v-model="fields.name" type="text" placeholder="Enter Name" required>
                                            <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label> Email</label>
                                            <input class="form-control" name="email" v-model="fields.email" type="text" placeholder="Enter email" required>
                                            <div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>
                                        </div>
                                        
                                        <div class="form-group col-md-12">
                                            <label> Photo</label>
                                            <input class="form-control" name="country_code" v-model="fields.country_code" type="text" placeholder="Enter country code" required>
                                            <div v-if="errors && errors.country_code" class="text-danger">{{ errors.country_code[0] }}</div>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" :disabled="isDisabled">
                                                <div v-if="busyWriting"><i class="fa fa-refresh fa-spin fa-fw"></i> Saving</div>
                                                <div v-else> Save</div>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- ./end edit modal -->
                    </tr>
                </tbody>
            </table>
            <!-- data pagination -->
            <pagination :data="users" @pagination-change-page="getUsers" :limit=3 align="right">
                <span slot="prev-nav">&lt; Previous</span>
                <span slot="next-nav">Next &gt;</span>
            </pagination>
        </div>
        <!-- ./end data table -->
        
        <!-- add modal -->
        <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myMediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myMediumModalLabel">Create User</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form method="POST" @submit.prevent="submit('add')">
                        <div class="modal-body row">
                            <div class="form-group col-md-12">
                                <label> Name</label>
                                <input class="form-control" name="name" v-model="fields.name" type="text" placeholder="Enter Name" required>
                                <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                            </div>
                            <div class="form-group col-md-12">
                                <label> Email</label>
                                <input class="form-control" name="email" v-model="fields.email" type="text" placeholder="Enter email" required>
                                <div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label> Country Code</label>
                                <input class="form-control" name="country_code" v-model="fields.country_code" type="text" placeholder="Enter country code" required>
                                <div v-if="errors && errors.country_code" class="text-danger">{{ errors.country_code[0] }}</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" :disabled="isDisabled">
                                <div v-if="busyWriting"><i class="fa fa-refresh fa-spin fa-fw"></i> Saving</div>
                                <div v-else> Save</div>
                            </button>
                        </div>
                    </form>
                </div>  
            </div>
        </div>
        <!-- ./end add modal -->
    </div>
</template>

<script>
    import FormMixin from '../shared/FormMixin';
    import DeleteMixin from '../shared/DeleteMixin';
    export default {
        mixins: [ FormMixin, DeleteMixin ],
        data() {
            return {
            'action': '/users/add',
            'action2': '/users/update',
            'text': 'User added succesfully',
            'text2': 'User updated succesfully',
            users: [],
            busy: false,
            busy1: false,
            busyWriting:false,
            showModal: false,
            fields: {
                id:'',
                name:'',
                email:'',
                photo:'',
            }
            }
        },

        watch:{
                completed:	function (value) { 
                        this.getUsers();
                        this.completed = false;
                    }
            },
        
        computed: {
            isDisabled(){
                return this.busy || this.busy1 || this.busyWriting;
            },
        },
        methods: {
            //load user data
            getUsers: function(page = 1){
                this.busy = true;
                axios.get('/users/get?page=' + page)
                .then(function(response){
                    this.busy = false;
                    this.users = response.data;
                }.bind(this));
            },
            //set edit value
            setEditValue(id,name,email,photo){
                this.fields.id = id;
                this.fields.name = name;
                this.fields.email = email;
                this.fields.photo = photo;
            }
        },
        created: function() {
            this.getUsers()
        }   
    }
</script>
