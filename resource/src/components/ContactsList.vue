<template>
    <div>
        <table class="table contacts">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Имя</td>
                    <td>Фамилия</td>
                    <td>Телефоны</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="contact in contacts">
                    <td>{{ contact.id}}</td>
                    <td>{{ contact.first_name}}</td>
                    <td>{{ contact.last_name}}</td>
                    <td>
                        <ul class="contact-phones">
                            <li v-for="phone in contact.phones">{{ phone.phone}}</li>
                        </ul>

                        <b-button size="md" variant="success" v-b-modal.addPhone>
                            Добавить номер
                        </b-button>
                    </td>
                    <td>
                        <b-button size="sm" class="mr-1" variant="primary">
                            <router-link style="color: white; " :to="{ name: 'contact', params: {id: contact.id } }">Редактировать</router-link>
                        </b-button>
                        <b-button size="sm" variant="danger" @click="deleteItems(contact.id)">
                            Удалить
                        </b-button>
                    </td>
                </tr>
            </tbody>
        </table>
        <b-modal id="addPhone" title="Добавление номера">

            <b-input
                    v-model="phoneNumber"
                    id="inline-form-input-name"
                    class="mb-2 mr-sm-2 mb-sm-0"
                    placeholder="+7(918) 123-45-56"
            ></b-input>
        </b-modal>
    </div>
</template>

<script>
  export default {
    name: "ContactsList",
    props: {
      searchValue: {
        type: String
      }
    },
    data() {
      return {
        searchString: '',
        phoneNumber: null,
        contacts: [],
        inProcess: false,
      }
    },
    created() {
        this.$api.get('contact').then(response => {
            console.log('created', response);
            this.contacts = response.data;
        })
    },
    methods: {
        deleteItems($id) {
            if (this.inProcess) return;

            this.inProcess = true;

            this.$api.delete('contact/' + $id).then(response => {
                console.log('created', response);
                this.contacts = this.removeFromArray(this.contacts, $id);
                this.inProcess = false;
            })
        },
        addPhone($id) {

        },
        removeFromArray(array, id) {
            return array.filter(el => el.id !== id);
        }
    }
  }
</script>

<style scoped>

</style>
