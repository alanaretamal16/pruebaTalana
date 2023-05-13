<script setup>
  // Importar las dependencias necesarias
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { Head } from "@inertiajs/vue3";
  import { Link, useForm, usePage } from '@inertiajs/vue3';
  import TextInput from '@/Components/TextInput.vue';
  import InputLabel from '@/Components/InputLabel.vue';
  import { ref } from 'vue';

  // Definir las propiedades necesarias
  defineProps({
    colors: {
      type: Object,
      required: true,
    },
  });

  // Obtener los colores de la página actual
  const colores = usePage().props.colors;

  // Definir la referencia para el formulario
  const form = useForm({
    color_id: null,
    edad: null,
  });

  // Definir la referencia para la variable showAlert
  const showAlert = ref(false);

  // Función para enviar el formulario
  const submitForm = () => {
    form.post(route('encuestas.store')).then(() => {
      showAlert.value = true; // Actualizar la variable showAlert
    });
  };
</script>

<template>
    <Head title="Welcome" />
    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Bienvenido</h2>
      </template>
  
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">¡Estás conectado!, Bienvenidos al Formulario</div>
          </div>
        </div>
      </div>
  
      <center>
        <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900 dark:text-gray-100">
                <div>
                  <b><h1>Encuesta:</h1></b>
  
                  <br>
  
                  <form @submit.prevent="submitForm">
                    <div>
                      <InputLabel for="edad" value="Edad:" />
                      <TextInput
                        type="number"
                        id="edad"
                        v-model="form.edad"
                        class="form-mt-1 block w-1/4 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        required
                      />
                    </div>
  
                    <br>
  
                    <div>
                      <InputLabel for="color_id" value="Color Favorito:" />
                      <select
                        id="color_id"
                        v-model="form.color_id"
                        name="color_id"
                        placeholder="selecciona color favorito"
                        v-on:loadeddata="colores"
                        class="form-mt-1 block w-1/4 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        required
                      >
                        <option value="" disabled hidden>
                          {{ form.color_id ? 'selecciona' : 'Selecciona color favorito ' }}
                        </option>
                        <option v-for="(value, key, index) in colores" :key="index" v-bind:value="key">
                          {{ value }}
                        </option>
                      </select>
                    </div>
  
                    <br>
  
                    <div>
                      <button
                        type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                      >
                        Contestar
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </center>
  
      <template>
        <div v-if="showAlert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
          <p class="font-bold">Encuesta respondida</p>
          <p>¡Gracias por tu respuesta!</p>
        </div>
      </template>
    </AuthenticatedLayout>
  </template>
  