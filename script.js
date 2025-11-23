// script.js
$(function(){
  const $form = $("#regForm");
  const $formSteps = $(".form-step");
  const $progress = $("#progress");
  const $progressSteps = $(".progress-step");
  let step = 0;

  function updateSteps(){
    $formSteps.removeClass("form-step-active").eq(step).addClass("form-step-active");
    $progressSteps.each(function(i){
      $(this).toggleClass("active", i <= step);
    });
    const activeCount = $progressSteps.filter(".active").length;
    const total = $progressSteps.length;
    const width = ((activeCount - 1) / (total - 1)) * 100;
    $progress.css("width", width + "%");
  }

  function validateStep(index){
    let valid = true;
    const $inputs = $formSteps.eq(index).find("input, select, textarea").filter("[required]");
    $inputs.each(function(){
      if(!$(this).val()){
        valid = false;
        $(this).addClass("invalid");
      } else {
        $(this).removeClass("invalid");
      }
    });

    // extra checks
    if(index === 0){
      const email = $("#email").val().trim();
      if(email && !/^\S+@\S+\.\S+$/.test(email)){ valid = false; $("#email").addClass("invalid"); }
    }
    if(index === 1){
      const sem = Number($("#semester").val());
      if(isNaN(sem) || sem < 1 || sem > 12){ valid = false; $("#semester").addClass("invalid"); }
    }
    return valid;
  }

  function fillReview(){
    $("#r_fullname").text($("#fullname").val());
    $("#r_studentid").text($("#studentid").val());
    $("#r_email").text($("#email").val());
    $("#r_dob").text($("#dob").val());
    $("#r_gender").text($("input[name='gender']:checked").val() || "");
    $("#r_college").text($("#college").val());
    $("#r_guardian").text($("#guardian_name").val() || "-");
    $("#r_guardian_phone").text($("#guardian_phone").val() || "-");
    $("#r_department").text($("#department").val());
    $("#r_course").text($("#course").val());
    $("#r_semester").text($("#semester").val());
    $("#r_address").text($("#address").val());
  }

  // next button
  $(document).on("click", ".btn-next", function(e){
    e.preventDefault();
    if(validateStep(step)){
      step++;
      updateSteps();
      if(step === $formSteps.length - 1){
        fillReview();
      }
    } else {
      alert("Please fill all required fields correctly before proceeding.");
    }
  });

  // prev button
  $(document).on("click", ".btn-prev", function(e){
    e.preventDefault();
    if(step > 0) step--;
    updateSteps();
  });

  // when the user submits the form, you can optionally do final validation
  $form.on("submit", function(){
    if(!validateStep(step)){
      alert("Please correct errors before submitting.");
      return false;
    }
    // show a quick disabled state to avoid double submit
    $(this).find("button[type='submit']").prop("disabled", true).text("Submitting...");
    return true; // allow form to be submitted to submit.php
  });

  // initial
  updateSteps();
});