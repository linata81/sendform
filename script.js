"use strict"

document.addEventListener('DOMContentLoaded', function(){
  const form = document.getElementById('form');
  form.addEventListener('submit', formSend);
  
  async function formSend(e) {
    e.preventDefault();
    
    let error = formValidate(form);
    
    //вытягиваем все данные полей
    let formData = new FormData(form); 
    //добавляем изображение, которое проверили и получили внизу
    formData.append('image', formImage.files[0]);
    
    //посмотреть соджержимое formData
    // for(let [name, value] of formData) {
    //   console.log(`${name} = ${value}`);
    // }
    
    if(error === 0) {
      form.classList.add('_sending');
      let response = await fetch('sendmail.php', {
        method: "POST",
        body: formData
      });
      if(response.ok) {
        let result = await response;
        console.log(result);
        formPreview.innerHTML = "";
        form.reset();
        form.classList.remove('_sending');
      }else {
        alert('ошибка');
        form.classList.remove('_sending');
      }
    }else {
      alert("Заполните обязательные поля");
    }
  }
  
  function formValidate(form) {
    let error = 0;
    let formReq = document.querySelectorAll('._req');
    
    for(let i = 0; i < formReq.length; i++) {
      const input = formReq[i];
      formRemoveError(input);
          
      if(input.classList.contains('_email')) {
        if(emailTest(input)) {
          formAddError(input);
          error++;
        }
      }else if(input.getAttribute("type") === "checkbox" && input.checked === false) {
        formAddError(input);
        error++;
      }else {
        if(input.value === "") {
          formAddError(input);
          error++;
        }
      }
    }
    
    return error;
  }
  function formAddError(input) {
    input.parentElement.classList.add('_error');
    input.classList.add('_error');
  }
  function formRemoveError(input) {
    input.parentElement.classList.remove('_error');
    input.classList.remove('_error');
  }
  function emailTest(input) {
    return !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(input.value);
  }
  
  //выводим на экран маленькие загруженые картинки
  const formImage = document.getElementById('formImage');
  const formPreview = document.getElementById('formPreview');
  
  //слушаем изменения в инпуте file
  formImage.addEventListener('change', () => {
    uploadFile(formImage.files[0]);
  });
  
  function uploadFile(file) {
    //проверяем тип файла
    if(!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
      alert('разрешены только изображения');
      formImage.value='';
      return;
    }
    
    //проверяем размер файла (<2 Мб)
    if(file.size > 2 * 1024 * 1024) {
      alert('файл должен быть менее 2 МБ')
      return;
    }
    
    let reader = new FileReader();
    reader.onload = function(e) {
      formPreview.innerHTML = `<img src="${e.target.result}" alt="Фото">`;
    };
    reader.onerror = function(e) {
      alert('ошибка');
    };
    reader.readAsDataURL(file);
  }
  
});