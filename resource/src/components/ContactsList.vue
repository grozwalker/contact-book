<template>
    <div>
        <b-table
                hover
                :fields="fields"
                :items="contacts"
                :filter="searchValue"
        >
            <template slot="actions" slot-scope="row">
                <b-button size="sm" class="mr-1" variant="primary">
                    <router-link style="color: white; " :to="{ name: 'contact', params: {id: row.item.id } }">Редактировать</router-link>

                </b-button>
                <b-button size="sm" variant="danger">
                    Удалить
                </b-button>
            </template>

        </b-table>
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
        contacts: [
          { id: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
          { id: 21, first_name: 'Larsen', last_name: 'Shaw' },
          { id: 89, first_name: 'Geneva', last_name: 'Wilson' },
          { id: 38, first_name: 'Jami', last_name: 'Carney' }
        ],
        fields: [
          { key: 'id', label: 'Id', sortable: true, sortDirection: 'desc' },
          { key: 'first_name', label: 'First Name', sortable: true },
          { key: 'last_name', label: 'Last Name', sortable: true },
          { key: 'actions', label: 'Actions' }
        ],
      }
    }
/*    computed: {
      filteredList() {
        return this.contacts.filter(contact => {
          return contact.first_name.toLowerCase().includes(this.searchValue.toLowerCase())
        })
      }
    }*/
  }
</script>

<style scoped>

</style>
