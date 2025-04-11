<!-- src/views/FileUpload.vue -->
<template>
    <div class="container">
      <h1>Upload File</h1>
  
      <form @submit.prevent="uploadFile">
        <input type="file" @change="handleFileChange" />
        <button type="submit">Upload</button>
      </form>
  
      <div v-if="uploadResult" class="result">
        <p> {{ uploadResult.message }}</p>
        <p> Path: {{ uploadResult.path }}</p>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import axios from 'axios'
  
  const file = ref(null)
  const uploadResult = ref(null)
  
  const handleFileChange = (e) => {
    file.value = e.target.files[0]
  }
  
  const uploadFile = async () => {
    if (!file.value) {
      alert('Pilih file terlebih dahulu!')
      return
    }
  
    const formData = new FormData()
    formData.append('file', file.value)
  
    try {
      const response = await axios.post('http://localhost:8000/api/upload', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      })
      uploadResult.value = response.data
    } catch (error) {
      console.error(error)
      alert('Gagal upload: ' + error.message)
    }
  }
  </script>
  
  <style scoped>
  .container {
    max-width: 500px;
    margin: 3rem auto;
    font-family: Arial, sans-serif;
  }
  button {
    margin-top: 1rem;
    padding: 10px 20px;
  }
  .result {
    margin-top: 1.5rem;
    background: #eef;
    padding: 1rem;
    border-radius: 8px;
  }
  </style>
  