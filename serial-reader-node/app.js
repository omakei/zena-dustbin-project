const { SerialPort } = require('serialport')
const fs = require('fs');
const axios = require('axios')

const port = new SerialPort({
  path: 'COM3',
  baudRate: 115200,
  autoOpen: false,
}).setEncoding('utf8')



// port.open(function (err) {
//   if (err) {
//     return console.log('Error opening port: ', err.message)
//   }

//   // Because there's no callback to write, write errors will be emitted on the port:
//   // port.write('main screen turn on')
// })


// // Switches the port into "flowing mode"
port.on('data', function (data) {
    // fs.appendFile('file.txt', data, err => {
    //     if (err) {
    //       console.error(err);
    //     }
    //   // done!
    // });
  
  //  fs.readFile('file.txt', 'utf8', (err, data_file) => {
  //     if (err) {
  //       console.error(err);
  //       return;
  //     }
  //     console.log('file_log:',data_file);
  //   });
  
  console.log('Data:', data)
})



// port.read()

// // port.close()

  //  fs.readFile('file.log', 'utf8', (err, data_file) => {
  //     if (err) {
  //       console.error(err);
  //       return;
  //     }
  //     console.log('file_log:',data_file.split('\n')[2]);
  //   });
  
const frequency = 10000;
const host = 'http://zena-dustbin-project.test'
setInterval(function () {
      fs.readFile('file.log', 'utf8', (err, data_file) => {
      if (err) {
        console.error(err);
        return;
        }

      axios.post(host+'/api/dustbin-update', {'data':data_file}).then((response) => {
          console.log(response.data);
      }).catch((error) => {
        console.log(error)
      })
      });  
  
}, frequency)

