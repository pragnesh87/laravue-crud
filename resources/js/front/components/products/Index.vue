<template>
  <h1>Proudct List</h1>
  <div class="d-flex justify-content-end">
    <button type="button" class="btn btn-primary" @click="newProduct">
      New Product
    </button>
  </div>
  <div class="row">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Image</th>
          <th scope="col">Name</th>
          <th scope="col">Type</th>
          <th scope="col">Quantity</th>
          <th scope="col">Price</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody class="table-group-divider">
        <tr v-for="item in products" :key="item.id" v-if="products.length > 0">
          <td>
            <img
              class="img-thumbnail"
              :src="ourImage(item.photo)"
              alt=""
              style="width: 5rem"
            />
          </td>
          <td>{{ item.name }}</td>
          <td>{{ item.type }}</td>
          <td>{{ item.quantity }}</td>
          <td>{{ item.price }}</td>
          <td>
            <button
              type="button"
              class="btn btn-success"
              @click="onEdit(item.id)"
            >
              Edit
            </button>
            <button
              type="button"
              class="btn btn-danger"
              @click="deleteProduct(item.id)"
            >
              Delete
            </button>
          </td>
        </tr>
        <tr v-else>
          <td colspan="6">Product Not Found</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { onMounted, ref } from '@vue/runtime-core';
import { useRouter } from 'vue-router';

let products = ref([]);
const router = useRouter();
onMounted(async () => {
  getProducts();
});

const getProducts = async () => {
  let response = await axios.get('/api/products');
  products.value = response.data.data;
};

const ourImage = (img) => {
  return '/upload/' + img;
};

const newProduct = () => {
  router.push('product/create');
};

const onEdit = (id) => {
  router.push('product/edit/' + id);
};

const deleteProduct = (id) => {
  Swal.fire({
    title: 'Are you sure to delete this?',
    text: "You can't go back",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonColor: '#d33',
  }).then((result) => {
    if (result.value) {
      axios.post(`/api/delete-product/${id}`).then(() => {
        toast.fire({
          icon: 'success',
          title: 'Product deleted successfully!',
        });

        getProducts();
      });
    }
  });
};
</script>
