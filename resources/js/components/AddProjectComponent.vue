<template>
    <div>
      <!-- Large modal -->
      <button type="button" class="btn btn-primary my-3" data-toggle="modal" data-target=".bd-example-modal-lg">Ajouter un projet</button>

      <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="col-md-12 col-sm-12">
            <div class="form-group">
              <label for="categories-projet">Selectionnez vos catégories</label>
              <li class="list-group-item" v-for="project in projects.data" :key="project.id">
                <a href="#">{{ project.title }}</a>
                <p>{{ project.description }}</p>
              </li>
            </div>
        </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
    export default {

      data() {
        return {
          projects: {}
        }
      },

      created(){
        axios
          .get('http://iziplans.test/projectsList')
          //.then(response => console.log(response.data))
          .then(response => this.projects = response.data)
          .catch(error => console.log(error))
      },

      methods: {
        getResults(page = 1) {
			    axios.get('http://iziplans.test/projectsList?page=' + page)
				      .then(response => {
					          this.projects = response.data;
				});
		}

      },

      mounted() {
        console.log('Component mounted.')
      }
    }
</script>
