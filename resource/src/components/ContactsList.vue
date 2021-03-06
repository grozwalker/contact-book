<template>
    <div>
        <table class="table table-striped table-hover contacts">
            <thead>
            <tr>
                <td>#</td>
                <td>Имя</td>
                <td>Фамилия</td>
                <td>Телефоны</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            <tr v-bind:key="contact.id" v-for="(contact, index) in filteredContacts">
                <td>{{ index + 1 }}</td>
                <td>{{ contact.first_name }}</td>
                <td>{{ contact.last_name }}</td>
                <td>
                    <ul class="contact-phones">
                        <li class="phone-row" v-bind:key="phone.id" v-for="phone in contact.phones">
                            <span clas="user-phone">{{ phone.phone }}</span>
                            <font-awesome-icon @click="deletePhone(phone.id)" class="delete-phone" icon="trash"/>
                        </li>
                    </ul>
                </td>
                <td>
                    <b-button @click="showModal(contact.id)" size="sm" variant="success">
                        Добавить номер
                    </b-button>
                    <b-button class="mr-1" size="sm" variant="primary">
                        <router-link :to="{ name: 'contact', params: {id: contact.id } }" style="color: white; ">
                            Редактировать
                        </router-link>
                    </b-button>
                    <b-button @click="deleteItems(contact.id)" size="sm" variant="danger">
                        Удалить
                    </b-button>
                </td>
            </tr>
            </tbody>
        </table>
        <b-modal hide-footer id="addPhone" ref="addPhone" title="Добавление номера">
            <b-input
                    class="mb-2 mr-sm-2 mb-sm-0"
                    id="inline-form-input-name"
                    pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                    placeholder="+7(918) 123-45-56"
                    type="tel"
                    v-model="phoneNumber"
            ></b-input>

            <b-button @click="addPhone" block class="mt-3" variant="success">Добавить</b-button>

            <b-button @click="hideModal" block class="mt-3" variant="outline-danger">Отмена</b-button>
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
        phoneNumber: null,
        contacts: [],
        currentUserId: null,
        inProcess: false,
      }
    },
    created() {
      this.fetchData();
    },
    methods: {
      fetchData() {
        this.$api.get('contact').then(response => {
          this.contacts = response.data;
        })
      },
      showModal(id) {
        this.currentUserId = id;
        this.$refs['addPhone'].show();
      },
      hideModal() {
        this.$refs['addPhone'].hide();
      },
      deleteItems(id) {
        if (this.inProcess) return;

        this.inProcess = true;

        this.$api.delete(`contact/${id}`).then(() => {
          this.contacts = this.removeFromArray(this.contacts, id);

          this.inProcess = false;
          this.$notify({
            group: 'main',
            type: 'warn',
            title: `Контакт #${id} успешно удален`
          });
        })
      },
      addPhone() {
        this.$api.post(`/contact/${this.currentUserId}/phone`, {
          phone: this.phoneNumber
        }).then(() => {
          this.fetchData();

        }).then(() => {
          this.hideModal();

          this.phoneNumber = null;
          this.$notify({
            group: 'main',
            type: 'success',
            title: `Телефон успешно добавлен`
          });
        })
      },
      deletePhone(id) {
        if (this.inProcess) return;

        this.inProcess = true;

        this.$api.delete(`phone/${id}`).then(() => {
          this.inProcess = false;

          this.$notify({
            group: 'main',
            type: 'warn',
            title: `Телефон успешно удален`
          });

          this.fetchData();
        })
      },
      removeFromArray(array, id) {
        return array.filter(el => el.id !== id);
      }
    },
    computed: {
      filteredContacts() {
        return this.contacts.filter(item => {
          return item.first_name.toLowerCase().indexOf(this.searchValue.toLowerCase()) > -1 ||
            item.last_name.toLowerCase().indexOf(this.searchValue.toLowerCase()) > -1
        });
      }
    }
  }
</script>

<style scoped>

</style>
