<script setup lang="ts">
  const eventEmitted = () => {
    console.log('event Emitted')
  };
</script>

<template>
  <div>
    <h1>App Component</h1>

    <testC @eventEmit="eventEmitted" :name=" 'Iago Vargas' "/>
  </div>
</template>

<style scoped>
  h1{
    color: green;
  }
</style>