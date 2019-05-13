<template>
    <b-container class="bv-example-row">
        <b-row>
            <b-col>
                <h1 class="text-left" v-if="this.$route.params.id">{{ fullName }}</h1>
                <h1 class="text-left" v-else>Создайте контакт</h1>
                <hr>
                <template>
                    <div>
                        <b-form @submit="onSubmit" class="form-horizontal text-left contact-form">
                            <b-form-group
                                    id="input-group-1"
                                    label="Имя"
                                    label-for="input-1"
                            >
                                <b-form-input
                                        id="input-1"
                                        placeholder="Введите имя"
                                        required
                                        type="text"
                                        v-model="contact.first_name"
                                ></b-form-input>
                            </b-form-group>
                            <b-form-group
                                    id="input-group-2"
                                    label="Фамилия"
                                    label-for="input-2"
                            >
                                <b-form-input
                                        id="input-2"
                                        placeholder="Введите фамилию"
                                        required
                                        type="text"
                                        v-model="contact.last_name"
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group
                                    aria-colcount="50"
                                    id="input-group-3"
                                    label="Досье"
                                    label-for="input-3"
                                    rows="50"
                            >
                                <b-form-textarea
                                        id="input-3"
                                        max-rows="15"
                                        placeholder="Enter something..."
                                        rows="15"
                                        v-model="contact.comment"
                                ></b-form-textarea>
                            </b-form-group>
                            <router-link :to="{ name: 'home'}" class="btn btn-outline-danger create-btn">
                                Назад
                            </router-link>
                            <b-button class="m-md-3" type="submit" variant="primary">Сохранить</b-button>
                        </b-form>
                    </div>
                </template>

            </b-col>
        </b-row>
    </b-container>
</template>

<script>

  export default {
    name: "Contact",
    props: {
      id: {
        'type': String,
      },
      currentContact: Object
    },
    data() {
      return {
        contact: {}
      }
    },
    created() {
      if (this.$route.params.id) {
        this.fetchData();
      }

    },
    methods: {
      fetchData() {
        this.$api.get(`contact/${this.$route.params.id}`).then(response => {
          this.contact = response.data;
        })
      },
      createUser(data) {
        return this.$api.post('contact', data).then(
          response => {
            this.contact = response.data;

            this.$notify({
              group: 'main',
              type: 'success',
              title: `Контакт успешно сохранен`
            });
          },
          error => {
            console.error(error);
            alert('Ошибка при сохранении данных');
            return Promise.reject(error);
          });
      },
      updateUser(data) {
        return this.$api.put(`contact/${this.$route.params.id}`, data).then(
          response => {
            this.contact = response.data;

            this.$notify({
              group: 'main',
              type: 'success',
              title: `Контакт успешно сохранен`
            });
          },
          error => {
            console.error(error);
            alert('Ошибка при сохранении данных');
            return Promise.reject(error);
          });
      },
      onSubmit(e) {
        e.preventDefault();

        if (this.$route.params.id) {
          this.updateUser(this.contact).then(() => {
            this.$router.push({name: 'home'})
          });
        } else {
          this.createUser(this.contact).then(() => {
            this.$router.push({name: 'home'})
          });
        }

      }
    },
    computed: {
      fullName() {
        return `${this.contact.first_name} ${this.contact.last_name}`
      }
    }
  }
</script>
