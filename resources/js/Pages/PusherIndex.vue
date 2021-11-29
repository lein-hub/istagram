<template lang="">
    <div>
        <h1>Pusher Test</h1>
        <p>
            Publish an event to channel <code>my-channel</code>
            with event name <code>my-event</code>; it will appear below:
        </p>
        <div id="app">
            <ul>
                <li v-for="message in messages">
                    {{message}}
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
Pusher.logToConsole = true;
var pusher = new Pusher('382fd0c7995fa0d7020a', {
    cluster: 'ap3'
});
var channel = pusher.subscribe('my-channel');
channel.bind('my-event', function(data) {
    app.messages.push(JSON.stringify(data));
});

export default {
    el: '#app',
    data: {
        messages: [],
    },
    mounted() {
        let recaptchaScript = document.createElement('script')
        recaptchaScript.setAttribute('src', 'https://js.pusher.com/7.0/pusher.min.js')
        document.head.appendChild(recaptchaScript)
        recaptchaScript.setAttribute('src', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js')
        document.head.appendChild(recaptchaScript)
    },
}
</script>
<style lang="">

</style>
