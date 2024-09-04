<template>
    <div>
        <h1>Link Page</h1>
        <button @click="generateNewLink">Generate New Link</button>
        <button @click="deactivateLink">Deactivate Link</button>
        <button @click="imFeelingLucky">I'm Feeling Lucky</button>
        <button @click="getHistory">History</button>

        <div v-if="result">
            <p>Random Number: {{ result.random_number }}</p>
            <p>Result: {{ result.result }}</p>
            <p>Prize: {{ result.prize }}</p>
        </div>

        <div v-if="history.length">
            <h2>History:</h2>
            <ul>
                <li v-for="entry in history" :key="entry.id">
                    {{ entry.random_number }} - {{ entry.result }} - Prize: {{ entry.prize }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            result: null,
            history: []
        };
    },
    methods: {
        generateNewLink() {
            axios.post(`/link/${this.$route.params.token}/generate`)
                .then(response => {
                    alert(`New link generated: ${response.data.new_link}`);
                });
        },
        deactivateLink() {
            axios.post(`/link/${this.$route.params.token}/deactivate`)
                .then(() => {
                    alert('Link deactivated');
                });
        },
        imFeelingLucky() {
            axios.post(`/link/${this.$route.params.token}/lucky`)
                .then(response => {
                    this.result = response.data;
                });
        },
        getHistory() {
            axios.get(`/link/${this.$route.params.token}/history`)
                .then(response => {
                    this.history = response.data;
                });
        }
    }
};
</script>
