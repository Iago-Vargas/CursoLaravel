<script setup lang="ts">
  /* Emit */
  /* Evento passado do filho para o pai exemplo que clicar em um botão e aparecer no pai*/
  const emit = defineEmits(['eventEmit']);

  /* Props */
  /* Evento passado do pai para o filho exemplo que clicar em um botão e aparecer no filho */
  const props = defineProps({
    name:{
      type: String,
      required: true
    }

  });

</script>

<template>
  <div>
    <button v-on:click="$emit('eventEmit')" type="button">Emit</button>
    <span>{{ props.name }}</span>
  </div>
</template>

<style scoped>
  h1{
    color: blue;
    font-size: 24px;
  }
</style>