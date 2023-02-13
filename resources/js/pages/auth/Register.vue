<template>
  <div id="RegisterPage">
          <Card title="Register" class="mt-3 mb-3">

            <div class="mt-3 mb-3 alert alert-danger" v-if="errors && Object.keys(errors).length">
              Some of your information is invalid please check and re-submit
            </div>

            <form @submit.prevent="register">
              <div class="grid grid-cols-1 gap-4">

                <div class="col" :class="{'block':(step===1),'hidden':(step !==1) }">
                  <div class="form-group mb-2">
                    <label>First name</label>
                    <input v-model="data.firstname" class="form-control" type="text" name="firstname" />
                    <div v-if="errors && errors.firstname" class="form-error">{{ errors.firstname[0]}}</div>
                  </div>
                  <div class="form-group mb-2">
                    <label>Last name</label>
                    <input v-model="data.lastname" class="form-control" type="text" name="lastname" />
                    <div v-if="errors && errors.lastname" class="form-error">{{ errors.lastname[0]}}</div>
                  </div>
                  <div class="form-group mb-2">
                    <label>Email Address</label>
                    <input v-model="data.email" class="form-control" type="text" name="email" />
                    <div v-if="errors && errors.email" class="form-error">{{ errors.email[0]}}</div>
                  </div>
                  <div class="form-group mb-2">
                    <label>Telephone</label>
                    <input v-model="data.telephone" class="form-control" type="text" name="telephone" />
                    <div v-if="errors && errors.telephone" class="form-error">{{ errors.telephone[0]}}</div>
                  </div>
                  <div class="my-3 text-center">
                    <button type="button" @click.prevent="nextStep" class="btn btn-primary">Next Step</button>
                  </div>
                </div>

                <div class="col" :class="{'block':(step===2),'hidden':(step !==2) }">
                  <div class="form-group mb-2">
                    <label>Key Skills</label>
                    <textarea v-model="data.skills" class="form-control" style="height:90px">
                    </textarea>
                    <small>e.g Lighting, Production, VFX, Camera, Post Production</small>
                    <div v-if="errors && errors.skills" class="form-error">{{ errors.skills[0]}}</div>
                  </div>
                  <div class="form-group mb-2">
                    <label>Date Of Birth</label>
                    <div class="flex gap-4">
                      <div>
                        <input v-model="data.day" class="form-control" type="number" min="1" max="31" />
                      </div>
                      <div>
                        <select v-model="data.month" class="form-control">
                          <option value="1">Jan</option>
                          <option value="2">Feb</option>
                          <option value="3">Mar</option>
                          <option value="4">Apr</option>
                          <option value="5">May</option>
                          <option value="6">Jun</option>
                          <option value="7">Jul</option>
                          <option value="8">Aug</option>
                          <option value="9">Sep</option>
                          <option value="10">Oct</option>
                          <option value="11">Nov</option>
                          <option value="12">Dec</option>
                        </select>
                      </div>
                      <div>
                        <input v-model="data.year" class="form-control" type="number" min="1940" :max="new Date().getFullYear()" />
                      </div>

                    </div>

                    <div v-if="errors && errors.dob" class="form-error">{{ errors.dob[0]}}</div>
                  </div>
                  <div class="form-group mb-2">
                    <label>Upload CV</label>
                    <input  class="form-control" type="file" ref="file" @change="addFile" accept=".pdf,.doc,.docx" />
                    <small>Word Document or PDF File. Max 12MB</small>
                    <div v-if="errors && errors.cvfile" class="form-error">{{ errors.cvfile[0]}}</div>
                  </div>
                  <div class="my-3 text-center">
                    <button type="button" @click.prevent="nextStep" class="btn btn-primary">Next Step</button>
                  </div>
                </div>
                <div class="col" :class="{'block':(step===3),'hidden':(step !==3) }">
                  <p>Please choose a password to return to your account</p>
                  <div class="form-group mb-2">
                    <label>Password</label>
                    <input v-model="data.password" class="form-control" type="password" />
                    <div v-if="errors && errors.password" class="form-error">{{ errors.password[0]}}</div>
                  </div>
                  <div class="form-group mb-2">
                    <label>Confirm Password</label>
                    <input v-model="data.password_confirmation" class="form-control" type="password" />
                    <div v-if="errors && errors.password_confirmation" class="form-error">{{ errors.password_confirmation[0]}}</div>
                  </div>
                  <div class="my-3 text-center">
                    <small>By signing Up you are agreeing to our terms and conditions and privacy policy</small>
                  </div>
                  <div class="my-3 text-center">

                    <button type="submit" class="btn btn-primary">Register</button>
                  </div>
                </div>

              </div>




            </form>

          </Card>
  </div>






</template>

<script>

export default {
  data: () => {
    return {
      data: {
        day:1,
        month:1,
        year:1990,
        firstname: null,
        lastname: null,
        telephone:null,
        email: null,
        password: null,
        password_confirmation: null,
        skills:null,
        cvfile:null
      },
      errors:{},
      step:1
    }
  },

  methods: {
    nextStep() {
      let self=this;
      let error=false;
      self.errors={};
      if(self.step===1) {
        if(!self.data.firstname) { error=true; self.errors.firstname=['You have not entered your firstname']; }
        if(!self.data.lastname) { error=true; self.errors.firstname=['You have not entered your lastname']; }
        if(!self.data.email) { error=true; self.errors.firstname=['You have not entered your email']; }
        if(!self.data.telephone) { error=true; self.errors.telephone=['You have not entered your phone number']; }
      }

      if(self.step===2) {
        if(!self.data.skills) { error=true; self.errors.skills=['You have not entered a list of skills']; }
        if(!self.data.day || !self.data.month || !self.data.year) { error=true; self.errors.dob=['You have not entered your date of birth']; }
        if(!self.data.cvfile) { error=true; self.errors.cvfile=['You have not uploaded your CV']; }

      }

      if(self.step===3) {
        if(!self.data.password) { error=true; self.errors.password=['You have not entered chosen a password']; }
        if(!self.data.password_confirmation) { error=true; self.errors.password_confirmation=['You have not confirmed your password']; }
        if(self.data.password_confirmation !== self.data.password) { error=true; self.errors.password_confirmation=['Your passwords do not match']; }

      }

      if(!error) {
        self.step++;
      }

    },

    addFile() {
      let self=this;
      self.data.cvfile=self.$refs.file.files[0];
    },
    register() {
      let self=this;
      self.errors = {};
      axios.get('/sanctum/csrf-cookie').then(response => {

        let formData = new FormData();
        var arr = self.data;

        for (let key in arr) {
          Array.isArray(arr[key])
            ? arr[key].forEach(value => formData.append(key + '[]', value))
            : formData.append(key, arr[key]) ;
        }

        formData.append('file',self.data.cvfile);

        axios.post('/api/register', formData,
          { headers: {'Content-Type': 'multipart/form-data'}})
          .then((response) => {
            this.$store.dispatch('attempt_user')
              .then(() => {
                this.$router.push({name: 'Account'})
              })
          })
          .catch((error) => {
            if(error.response.status===413) {
              self.errors.cvfile=['The file you have uploaded is too large. Max 12MB'];
              self.step=2;
            } else {
              self.step=1;
              self.errors = error.response.data.errors
            }

          })
      });
    }
  }
}
</script>
