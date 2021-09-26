<template>
    <div class="container">
      <add-project></add-project>
      <ul class="list-group">
        <li class="list-group-item" v-for="(project)in projects.data" :key="project.id">
          <a href="#">{{ project.title }}</a>
          <p>{{ project.description }}</p>
        </li>
      </ul>
      <pagination :data="projects" @pagination-change-page="getResults" class="mt-5"></pagination>
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
