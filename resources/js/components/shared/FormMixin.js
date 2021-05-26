export default {
    data() {
      return {
        fields: {},
        data: {},
        errors: {},
        success: false,
        loaded: true,
        action: '', //action url
        text: '',
        redirect: '',
        completed: false,
        busyWriting:false,
        
      }
    },
  
    methods: {
      //get the file
      onFileChange(e){
        console.log(e.target.files[0]);
        this.fields.photo = e.target.files[0];
        },
        //submit data with files
      formSubmit(e) {
          this.busyWriting = true;//
            e.preventDefault();
            let currentObj = this;
            const config = {
                headers: { 'content-type': 'multipart/form-data','content-type': 'application/json' },
                    }
            let formData = new FormData();
            formData.append('photo', this.fields.photo);
            formData.append('id', this.fields.id ?? '');
            formData.append('name', this.fields.name ?? '');
            formData.append('email', this.fields.email ?? '');
            axios.post(this.action, formData, config)
            .then(response => {
              currentObj.success = true;
              this.busyWriting = false;//
              this.completed = true;
              var mtext = this.text;
              var back = this.redirect;
              swal({
                title: 'Success',
                text: mtext,
                icon: 'success',
                timer:2000,
                type: 'success',
                buttons:{
                    confirm: {
                    text : 'Close',
                    className : 'btn btn-danger'
                    },
                    cancel: {
                    text: 'Continue',
                    visible: true,
                    className: 'btn btn-info'
                    }
                }
                }).then((Delete) => {
                  if (Delete) {
                    swal.close();
                    $('.modal-backdrop').remove();
                    $('.modal').hide('modal');
                  } else {
                      swal.close();
                  }
              });
              swal.close();
              $('.modal').hide('modal');
              $('.modal-backdrop').remove();    
        })
      .catch(error => {
          if (error.response.status === 422) {
                this.busyWriting = false;//
                this.errors = error.response.data.errors || {};                
              }
              else if (error.response.status === 400)
              {
                this.busyWriting = false;//
                this.errors = error.response.data;
                // start fail
                swal({
                  title: 'Oops!',
                  icon: 'error',
                  text: this.errors,
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
                this.busyWriting = false;//
                // start fail
                swal({
                  title: 'Oops!',
                  icon: 'error',
                  text: 'Failed! An error occurred. Please try again',
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
          console.log(this.errors);
          }).bind(this);
      },
      //add /edit user
      submit(theaction) {
        this.busyWriting = true;//
        if (this.loaded) {
          this.loaded = false;
          this.success = false;
          this.errors = {};
          // get urls and success messages 
          if(theaction == 'add')
          {
            var action = this.action;
            var message = this.text;
          }
          else if(theaction == 'edit') {
            var action = this.action2;
            var message = this.text2;
          }
          axios.post(action, this.fields).then(response => {
            // this.fields = {}; //Clear input fields.
            this.loaded = true;
            this.success = true;
            this.busyWriting = false;//
            //sweet alert with redirect
            var mtext = message;
            var back = this.redirect;
            this.completed = true;
            swal({
              title: 'Success',
              text: mtext,
              icon: 'success',
              type: 'success',
              buttons:{
                confirm: {
                  text : 'Close',
                  className : 'btn btn-danger'
                },
                cancel: {
                  text: 'Continue..',
                  visible: true,
                  className: 'btn btn-info'
                }
              }
            }).then((Delete) => {
              if (Delete) {
                swal.close();
              } else {
                swal.close();
              }
            });

          }).catch(error => {
            this.loaded = true;
            if (error.response.status === 422) {
              this.busyWriting = false;
              this.errors = error.response.data.errors || {};
            }
            else if (error.response.status === 400)
                  {
            this.busyWriting = false;
            this.errors = error.response.data;
              // start fail
              swal({
                title: 'Oops!',
                icon: 'error',
                text: this.errors,
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
            else {
              this.errors = error.response.data.errors || {};
              this.busyWriting = false;//
              // start fail
              swal({
                title: 'Oops!',
                icon: 'error',
                text: 'Failed! An error occurred. Please try again',
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
          });
        }
      },
    },
  }
