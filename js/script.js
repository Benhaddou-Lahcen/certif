let body = document.body;

let profile = document.querySelector('.header .flex .profile');

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   searchForm.classList.remove('active');
}

let searchForm = document.querySelector('.header .flex .search-form');

document.querySelector('#search-btn').onclick = () =>{
   searchForm.classList.toggle('active');
   profile.classList.remove('active');
}

let sideBar = document.querySelector('.side-bar');

document.querySelector('#menu-btn').onclick = () =>{
   sideBar.classList.toggle('active');
   body.classList.toggle('active');
}

document.querySelector('.side-bar .close-side-bar').onclick = () =>{
   sideBar.classList.remove('active');
   body.classList.remove('active');
}

document.querySelectorAll('input[type="number"]').forEach(InputNumber => {
   InputNumber.oninput = () =>{
      if(InputNumber.value.length > InputNumber.maxLength) InputNumber.value = InputNumber.value.slice(0, InputNumber.maxLength);
   }
});

window.onscroll = () =>{
   profile.classList.remove('active');
   searchForm.classList.remove('active');

   if(window.innerWidth < 1200){
      sideBar.classList.remove('active');
      body.classList.remove('active');
   }

}

let toggleBtn = document.querySelector('#toggle-btn');
let darkMode = localStorage.getItem('dark-mode');

const enabelDarkMode = () =>{
   toggleBtn.classList.replace('fa-sun', 'fa-moon');
   body.classList.add('dark');
   localStorage.setItem('dark-mode', 'enabled');
}

const disableDarkMode = () =>{
   toggleBtn.classList.replace('fa-moon', 'fa-sun');
   body.classList.remove('dark');
   localStorage.setItem('dark-mode', 'disabled');
}

if(darkMode === 'enabled'){
   enabelDarkMode();
}

toggleBtn.onclick = (e) =>{
   let darkMode = localStorage.getItem('dark-mode');
   if(darkMode === 'disabled'){
      enabelDarkMode();
   }else{
      disableDarkMode();
   }
}


var timeLeft;
var data;
var videos;
async function loadQuiz()
{
   try {
      const response = await fetch("./quiz-data/quiz-fullstack-webdev.json");
      data = await response.json();
      console.log(data["quiz-fullstack-webdev"]["duration"]);
      timeLeft = parseInt(data["quiz-fullstack-webdev"]["duration"]) * 60;
      console.log(timeLeft);
      const quizContainer = document.getElementById("quiz-container");
      var i = 1, j = 1;
      data["quiz-fullstack-webdev"]["questions"].forEach(question => {
         j = 1;
         var box = document.createElement('div');
         var title = document.createElement('h3');
         title.innerHTML = `${question["question"]}`;
         var tutor = document.createElement('div');
         var info = document.createElement('div');
         box.className = "box";
         title.className = "title";
         tutor.className = "tutor";
         info.className = "info";
         question["options"].forEach(option => {
            info.innerHTML += `
            <div class="answer" style="font-size: large">
               <label><input type="${question["type"] == 'mcq' ? 'checkbox' : 'radio'}" id="${j}" name="Q${i}${question["type"] == 'mcq' ? '[]' : ''}" value="${option.replace(/</g, '&lt;').replace(/>/g, '&gt;')}"> ${option}</label>
            </div>
         `;
         j++;
         });
         i++;
         box.appendChild(title);         
         box.appendChild(tutor);         
         tutor.appendChild(info);
         quizContainer.prepend(box);         
      });
   } catch(error) {
      console.error("error loading quiz :", error);
   };
   
}

setInterval(() => {
   document.querySelector("#timer").innerHTML = `Time left : ${Math.floor(timeLeft / 60)} : ${timeLeft % 60}`;
   timeLeft--;
   if (timeLeft == 0) {
      submitQuiz();
   };
}, 1000);



async function loadVideos()
{
   try {
      const response = await fetch("./courses/course-fullstack-webdev.json");
      data = await response.json();
      const courseContainer = document.getElementById("course-container");
      var i = 1;
      data["course-fullstack-webdev"]["videos"].forEach(question => {
         // var box = document.createElement('div');
         // var title = document.createElement('h3');
         // title.innerHTML = `Lesson ${i}`;
         // var tutor = document.createElement('div');
         // var info = document.createElement('div');
         // box.className = "box";
         // title.className = "title";
         // tutor.className = "tutor";
         // info.className = "info";
         courseContainer.innerHTML +=`
         <form action="watch_video.php" method="post">
            <input type="hidden" name="vid" value="${question}">
            <button type="submit" class="box">
               <i class="fas fa-play"></i>
               <img src="images/post-1-${i}.png" alt="">
               <h3>FullStack Course (part ${i})</h3>
            </button>
         </form>

         `;
         i++;
         // box.appendChild(title);         
         // box.appendChild(tutor);         
         // tutor.appendChild(info);
         // courseContainer.prepend(box);         
      });
   } catch(error) {
      console.error("error loading quiz :", error);
   };
   
}