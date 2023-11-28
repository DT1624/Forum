const fs = require('fs');

// Tạo đối tượng JSON mô tả bản thân
const myInfo = {
    name: 'Your Name',
    age: 25,
    location: 'Your City',
    hobbies: ['Reading', 'Coding', 'Traveling'],
    email: 'your.email@example.com',
};

// Chuyển đối tượng thành chuỗi JSON
const jsonData = JSON.stringify(myInfo, null, 2);

// Tên tệp tin để lưu dữ liệu JSON
const fileName = 'myInfo.json';

// Ghi dữ liệu vào tệp tin
fs.writeFileSync(fileName, jsonData);

console.log(`File ${fileName} đã được tạo thành công.`);
