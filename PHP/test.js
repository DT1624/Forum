var json = `{
    "ID": "22028334",
    "Name": {
      "firstName": "Tran",
      "lastName": "Duong"
    },
    "old": "19",
    "hometown": "Tam Dao, Vinh Phuc",
    "address": "My Dinh, Ha Noi",
    "citizenID": "026204003525",
    "university": "UET",
    "major": "computer science",
    "hobbies": [
      {
        "sport": [
          "babminton",
          "football",
          "chess",
          "basketball"
        ]
      },
      "listen music",
      "video games"
    ],
    "contact": {
      "email": "anhduonghctdvp@gmail.com",
      "phone": "0388959369"
    },
    "family": {
      "father": {
        "name": "",
        "age": "43"
      },
      "mother": {
        "name": "",
        "age": "41"
      },
      "sister": {
        "name": "",
        "age": "20"
      }
    }
  }`;
  
   // Chuyển từ đối tượng JSON thành đối tượng JS
   var obj = JSON.parse(json);
   function printValues(obj) {
    for (var k in obj) {
        console.log(k);
    if (obj[k] instanceof Object) {
    printValues(obj[k]);
    } else {
    console.log(obj[k]);
    };
    }
   };
   // In ra tất cả các giá trị
   printValues(obj);
   console.log(obj["book"]["author"]); 
   console.log(obj["book"]["coAuthors"][0]); 
   console.log(obj["book"]["price"]["hardcover"]);