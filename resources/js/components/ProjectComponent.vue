<template>
    <div class="container">
      <add-project></add-project>

      <ul class="list-group">
        <li class="list-group-item" v-for="departement in query.departements" :key="departement.id">
          <p>{{ departement.name }}</p>
        </li>
      </ul>
      <ul class="list-group my-5">
        <li class="list-group-item" v-for="categorie in query.categories" :key="categorie.id">
          <p>{{ categorie.name }}</p>
        </li>
      </ul>
      <!-- <pagination :data="projects" @pagination-change-page="getResults" class="mt-5"></pagination> -->
    </div>
</template>

<script>
    export default {

      data() {
        return {
          query: {}
        }
      },

      created(){
        axios
          .get('http://iziplans.test/projectsList')
          //.then(response => console.log(response.data))
          .then(response =>this.query = response.data)
          //.then(response =>this.departements = response.data.departements)
          .catch(error => console.log(error))
      },

      methods: {

		},


      mounted() {

        console.log('Component mounted.')
      }
    }
</script>
