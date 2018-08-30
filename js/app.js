let vm = new Vue({

  el: '#app',
  data: {
    message: 'maximum raspect',
    success: true,
    options: ['Choisir le type...', 'Roll-Up First Line', 'Roll-Up Best Line', 'Roll-Up Lux Line']
  },
  methods: {
    close: function() {
      this.success = false;
    }
  }

});
