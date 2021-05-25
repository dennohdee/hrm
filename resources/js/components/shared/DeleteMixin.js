import swal from "sweetalert";

export default {
    data() {
      return {
        
        fields: {},
        errors: {},
        loaded: true,
        action: '', 
        text: '',
        redirect: '',
        busy:false,
        completed: false,
      }
    },  
    methods: {  
      //method for deleting 
      deleteItem: function deleteItem(path,id){
       
        var deleteuser = '/users/delete/';

        var fpath='';
        var item='';
        if(path == 'deleteuserpath')
        {
          fpath=deleteuser;
          item="User"
        }
        
       swal({
              title:'Sure to delete?',id,
              text: 'Delete '+item,
              icon: 'warning',
              type: 'warning',
              buttons:{
                confirm: {
                  text : 'Sure',
                  className : 'btn btn-success'
                },
                cancel: {
                  visible: true,
                  className: 'btn btn-danger'
                }
              }
            }).then((Delete) => {
              if (Delete) {
            axios.get(fpath +id).then(function (response) {
                this.completed = true;
                swal({
                  title: 'Deleted!',
                  icon: 'success',
                  text: item+' has been deleted.',
                  type: 'success',
                  buttons : {
                    confirm: {
                      className : 'btn btn-success'                 
                    }
                  }             
                }).then(function(){
                  swal.close();
                });
              
             }.bind(this)).catch(function (error) {
              this.loaded = true;
             if (error.response.status === 400)
              {
                // start fail
                swal({
                  title: 'Oops!',
                  icon: 'error',
                  text: error.response.data,
                  type: 'failure',
                  buttons : {
                    confirm: {
                      className : 'btn btn-danger'                 
                    }
                  }             
                }).then(function(){
                  window.location.href = '';
                });
                // end fail
              }
              else  
              {  
                // start fail
                swal({
                  title: 'Oops!',
                  icon: 'error',
                  text: 'An error occurred. Please try again later',
                  type: 'error',
                  buttons : {
                    confirm: {
                      className : 'btn btn-danger'                 
                    }
                  }             
                }).then(function(){
                  window.location.href = '';
                });
                // end fail
              }
              this.loaded = false;
            }.bind(this));
          } else {
                swal.close();
            }
        });
      },
    }
}
