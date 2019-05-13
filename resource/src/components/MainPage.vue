<template>
    <b-container class="bv-example-row">
        <b-row>
            <b-col>

                <div>
                    <b-jumbotron bg-variant="info" text-variant="white" border-variant="dark">
                        <template slot="header">Contacts list</template>

                        <template slot="lead">
                            Search & Call
                        </template>

                        <hr class="my-4">

                        <div>
                            <b-form inline align="center">
                                <label class="sr-only" for="inline-form-input-name">Name</label>
                                <b-input
                                        v-model="search"
                                        id="inline-form-input-name"
                                        class="mb-2 mr-sm-2 mb-sm-0"
                                        placeholder="Jane Doe"
                                ></b-input>

                                <b-button variant="light">Search</b-button>
                            </b-form>
                        </div>
                    </b-jumbotron>
                    {{ search }}
                </div>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <ContactsList :searchValue="search" />
            </b-col>
        </b-row>
        <b-row align="start">
            <b-col>
                <b-button size="md" class="mr-1" variant="success">
                    Добавить контакт
                </b-button>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
  import Vue from 'vue'
  import BootstrapVue from 'bootstrap-vue'

  import 'bootstrap/dist/css/bootstrap.css'
  import 'bootstrap-vue/dist/bootstrap-vue.css'

  Vue.use(BootstrapVue);

  import ContactsList from './ContactsList'

  export default {
    name: "MainPage",
    components: {
      ContactsList
    },
    data() {
        return {
            search: ''
        }
    }
  }
</script>

<style scoped>

</style>
