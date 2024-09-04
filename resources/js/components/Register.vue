<template>
    <div>
        <h1>Register</h1>
        <form @submit.prevent="register">
            <input v-model="username" type="text" placeholder="Username" required />
            <input v-model="phone_number" type="text" placeholder="Phone number" required />
            <button type="submit">Register</button>
        </form>
        <p v-if="link">Your link: <a :href="link">{{ link }}</a></p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            username: '',
            phone_number: '',
            link: null,
        };
    },
    methods: {
        register() {
            axios.post('/register', {
                username: this.username,
                phone_number: this.phone_number,
            }).then(response => {
                this.link = response.data.link;
            }).catch(error => {
                console.error(error);
            });
        }
    }
};
</script>
