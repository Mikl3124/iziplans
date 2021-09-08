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
                <select v-model="categories">
                <option v-bind:value="categorie" v-for="categorie in query.categories" :key="categorie.id">{{ categorie.name }}</option>
              </select>
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
          query: {},
          categories: {}
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
