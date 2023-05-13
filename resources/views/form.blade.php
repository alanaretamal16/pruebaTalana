<template>
  <div>
    <h1>Create Person</h1>
    <form @submit.prevent="submitForm">
      <div>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" v-model="form.age">
      </div>
      <div>
        <label for="color_id">Color:</label>
        <select id="color_id" name="color_id" v-model="form.color_id">
          @foreach($colors as $color)
            <option value="{{ $color->id }}">{{ $color->name }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit">Create Person</button>
    </form>
  </div>
</template>

<script>
  import { useForm } from '@inertiajs/inertia-vue';
  import route from 'ziggy';

  export default {
    props: {
      colors: Array,
    },
    setup() {
      const { data: form, post, processing } = useForm({
        age: '',
        color_id: '',
      });

      const submitForm = () => {
        post(route('people.store'));
      };

      return {
        form,
        processing,
        submitForm,
      };
    },
  };
</script>
