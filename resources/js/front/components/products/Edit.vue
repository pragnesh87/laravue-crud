<template>
  <div class="mb-3 row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="" v-model="form.name" />
    </div>
  </div>
  <div class="mb-3 row">
    <label for="inputPassword" class="col-sm-2 col-form-label"
      >Description</label
    >
    <div class="col-sm-10">
      <textarea
        name="description"
        id="description"
        class="form-control"
        cols="30"
        rows="10"
        v-model="form.description"
      ></textarea>
    </div>
  </div>
  <div class="mb-3 row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Type</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="" v-model="form.type" />
    </div>
  </div>
  <div class="mb-3 row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Quantity</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="" v-model="form.quantity" />
    </div>
  </div>
  <div class="mb-3 row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Price</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="" v-model="form.price" />
    </div>
  </div>
  <div class="mb-3 row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Photo</label>
    <div class="col-sm-10">
      <input type="file" class="form-control" id="" @change="updatePhoto" />
    </div>
  </div>

  <img :src="getPhoto()" class="img-thumbnail" alt="image" />
  <div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3" @click="updateProduct()">
      Save
    </button>
  </div>
</template>

<script setup>
import { onMounted, ref } from '@vue/runtime-core';
import { useRouter } from 'vue-router';

let form = ref({
  name: '',
  description: '',
  photo: '',
  type: '',
  quantity: '',
  price: '',
});

const router = useRouter();

onMounted(async () => {
  getProduct();
});

const props = defineProps({
  id: {
    type: String,
    default: '',
  },
});

const getProduct = async () => {
  let response = await axios.get(`/api/product/${props.id}`);
  form.value = response.data.data;
};

const getPhoto = () => {
  let photo = '/upload/image.png';
  if (form.value.photo) {
    if (form.value.photo.indexOf('base64') != -1) {
      photo = form.value.photo;
    } else {
      photo = '/upload/' + form.value.photo;
    }
  }
  return photo;
};

const updatePhoto = (e) => {
  let file = e.target.files[0];
  let reader = new FileReader();
  let limit = 1024 * 1024 * 2;
  if (file['size'] > limit) {
    return false;
  }
  reader.onloadend = (file) => {
    form.value.photo = reader.result;
  };
  reader.readAsDataURL(file);
};

const updateProduct = () => {
  const formData = new FormData();
  formData.append('name', form.value.name);
  formData.append('description', form.value.description);
  formData.append('type', form.value.type);
  formData.append('quantity', form.value.quantity);
  formData.append('price', form.value.price);
  formData.append('photo', form.value.photo);

  axios
    .post(`/api/update-product/${props.id}`, formData)
    .then((response) => {
      toast.fire({
        icon: 'success',
        title: 'Product updated successfully!',
      });

      router.push('/');
    })
    .catch((error) => {});
};
</script>
