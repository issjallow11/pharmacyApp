<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="card">
            <div class="card-header bg-blue">Sale Component</div>

            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Cost Price</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <!-- <table>Iphne</table> -->
                    <td>Iphone</td>
                    <td>this is an iphone</td>
                    <td>200</td>
                    <td>
                      <a href="">
                        <i class="fas fa-cart-plus">Add</i>
                      </a>
                      
                      
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return{
      products: {}
    }
  },
  mounted() {
    console.log('Component mounted.')
  },

  methods:{
    loadProducts(){
      axios.get('api/product')
        .then(({ data }) => {
          this.products = data.data
        }).catch(({ err }) => {
          console.log(err)
        })
    }
  },
  created(){
    this.$Progress.start();
    this.loadProducts();
    this.$Progress.finish();
  }
}
</script>

<style scoped>
/* .card-body{
  display: flex;
  flex-direction: column;
  height: 100%;
}
.row1{
  flex: 1;
  background-color: red;
} */
</style>
