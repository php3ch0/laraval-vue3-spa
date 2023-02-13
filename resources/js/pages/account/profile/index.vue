<template>

  <div id="ProfilePage">

    <teleport to="head">
      <title>Portside Film and Media Recruitment | Account</title>
      <meta name="description" content="Manage Your Account" />
    </teleport>

    <div v-if="success" class="mt-3 mb-3 alert alert-success">Your changes have been saved</div>

      <Loading v-if="loading" />

      <form v-else @submit.prevent="update" class=" grid grid-cols-1 lg:grid-cols-2 gap-4">

        <div class="col">
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
        </div>

        <div class="col">
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
        </div>
        <div class="mt-3 mb-3">
          <button type="submit" class="btn btn-primary">
            Save Changes
          </button>
        </div>
      </form>
  </div>
</template>

<script>
import Loading from "../../../components/Loading";
export default {
  components: {Loading},
  data() {
    return {
      loading:false,
      errors: {},
      data: {},
      success:false,
    }
  },
  mounted() {
    this.getUser();
  },

  methods: {
    getUser() {
      let self=this;
      axios.get('/api/user').then(function(res) {
        self.data=res.data.data;
      })
    },
    addFile() {
      let self=this;
      self.data.cvfile=self.$refs.file.files[0];
    },
    update() {
      let self=this;
      self.loading=true;
      self.errors = {};
      self.success=false;

      let formData = new FormData();
      let arr = self.data;

      for (let key in arr) {
        Array.isArray(arr[key])
          ? arr[key].forEach(value => formData.append(key + '[]', value))
          : formData.append(key, arr[key]) ;
      }

      formData.append('file',self.data.cvfile);

      axios.post('/api/user', formData,
        { headers: {'Content-Type': 'multipart/form-data'}})
        .then((response) => {
          this.$store.dispatch('attempt_user');
          self.loading=false;
          self.success=true;
          setTimeout(function() {
            self.success=false;
          },4000);
        })
        .catch((error) => {
          if(error.response.status===413) {
            self.errors.cvfile=['The file you have uploaded is too large. Max 12MB'];
          } else {
            self.errors = error.response.data;
            if(self.errors.day || self.errors.month || self.errors.year) {
              self.errors.dob=['You have not entered your date of birth'];
            }
          }
          self.loading=false;
        })
    },
  }
}
</script>
