<template>
    <div>
        <b-table
                hover
                :fields="fields"
                :items="contacts"
                :filter="searchValue"
        >
            <template slot="actions">
                <b-button size="sm" class="mr-1" variant="primary">
                    Редактировать
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
          { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
          { age: 21, first_name: 'Larsen', last_name: 'Shaw' },
          { age: 89, first_name: 'Geneva', last_name: 'Wilson' },
          { age: 38, first_name: 'Jami', last_name: 'Carney' }
        ],
        fields: [
          { key: 'age', label: 'First Name', sortable: true, sortDirection: 'desc' },
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
