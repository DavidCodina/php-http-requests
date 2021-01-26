/* =============================================================================
                               Variables
============================================================================= */


const url        = 'process.php';
//Not actually json yet, but Axios will automatically serialize it.
const json       = { id: 123, first_name: 'Joe', last_name: 'Bazooka', is_cool: true };
const stringData = "id=123&first_name=Joe&last_name=Bazooka&is_cool=true";
const formData   = new FormData();


formData.append('id',         123);
formData.append('first_name', 'Joe');
formData.append('last_name',  'Bazooka');
formData.append('is_cool',     true);


/* =============================================================================
                          GET Button Click Listener
============================================================================= */


document.getElementById('get-data-button').addEventListener('click', function(){
  getData('process.php?id=123&first_name=Joe&last_name=Bazooka&is_cool=true')
  .then(res  => { console.log(res.data); })
  .catch(err => { console.error(err);    });
});


/* =============================================================================
                        POST Button Click Listener
============================================================================= */


document.getElementById('post-data-button').addEventListener('click', function(){
  postData(url, json) // json || formData || stringData
  .then(res  => { console.log(res.data); })
  .catch(err => { console.error(err);    });
});


/* =============================================================================
                        PUT Button Click Listener
============================================================================= */


document.getElementById('put-data-button').addEventListener('click', function(){
  putData(url, json) // json || formData || stringData
  .then(res  => { console.log(res.data); })
  .catch(err => { console.error(err);    });
});


/* =============================================================================
                      PATCH Button Click Listener
============================================================================= */


document.getElementById('patch-data-button').addEventListener('click', function(){
  patchData(url, json) // json || formData || stringData
  .then(res  => { console.log(res.data); })
  .catch(err => { console.error(err);    });
});


/* =============================================================================
                      DELETE Button Click Listener
============================================================================= */


document.getElementById('delete-data-button').addEventListener('click', function(){
  const config = {
    //Gotcha: If sending data in a DELETE request, and data is stringData,
    //Then you must set the Axios 'Content-Type' header. Otherwise, don't set it.
    //headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    data: json, // json || formData || stringData || or omit data property all together.
    timeout: 1000 * 25
  };

  deleteData(url, config)
  .then(res  => { console.log(res.data); })
  .catch(err => { console.error(err);    });
});
