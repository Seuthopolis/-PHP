<?php
echo '<pre>';
var_dump($_POST);
echo '</pre>';

// Form vars
$formSubmited = count($_POST) > 0;
$formValid = true;
$formErrors;
$userName = $_POST['userName'];
$emailAddress = $_POST['emailAddress'];
$password = $_POST['password'];
$uppercase = preg_match('@[A-Z]@', $password);
$lowercase = preg_match('@[a-z]@', $password);
$number    = preg_match('@[0-9]@', $password);
$repeatPassword = $_POST['repeatPassword'];
$city = $_POST['city'];

// Check if form is submited
if ($formSubmited) {
    echo 'Form is submited <br>';

    // Check for userName
    if (isset($userName) && $userName == '') {
        $formValid = false;
        $formErrors['userName'] = 'Please enter your user name';
    }

    //Check for email
    if (isset($emailAddress) && $emailAddress == '') {
        $formValid = false;
        $formErrors['emailAddress'] = 'Please enter your email address';
    } elseif (isset($emailAddress) && !filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
        $formValid = false;
        $formErrors['emailAddress'] = 'Invalid email format';
    }

    //Check for password
    if (isset($password) && $password == '') {
        $formValid = false;
        $formErrors['password'] = 'Please enter password';
    } elseif (isset($password) && (!$uppercase || !$lowercase || !$number || strlen($password) < 8)) {
        $formValid = false;
        $formErrors['password'] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one lowercase character and one number.';
    }

    //Check for pepeat password
    if (isset($repeatPassword) && $repeatPassword == '') {
        $formValid = false;
        $formErrors['repeatPassword'] = 'The field cannot be empty';
    } elseif ($repeatPassword != $password) {
        $formValid = false;
        $formErrors['repeatPassword'] = 'The field value must match password';
    }

    //Check for selected options
    if (isset($city) && $city == '-1') {
        $formValid = false;
        $formErrors['city'] = 'Please select an option from the select box.';
    }

    //Check for agreement
    if (!isset($_POST['userAgreement'])) {
        $formValid = false;
        $formErrors['userAgreement'] = 'Please indicate that you accept the Terms and Conditions';
    }
} else {
    echo 'Form is not submited <br>';
}

echo 'Form is ' . ($formValid == true ? 'Valid' : 'Invalid');

echo '<pre>';
var_dump($formErrors);
echo '</pre>';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

    <title>Register form</title>
</head>

<body>
<main>
    <div class="container py-4">
        <div class="row">
            <div class="offset-lg-3 col-lg-6">
                <div class="card text-white bg-secondary">
                    <div class="card-header">
                        <h3 class="mb-0">Sign Up</h3>
                    </div>
                    <div class="card-body bg-dark">
                        <form action="index.php" method="POST" id="signUpform" novalidate>
                            <div class="form-group">
                                <label for="userName">Username*</label>
                                <input type="text" value="<?php echo ($formSubmited ? (isset($userName) ? $userName : '') : ''); ?>" name="userName" id="userName" class="form-control <?php echo ($formSubmited ? (isset($formErrors['userName']) ? 'is-invalid' : 'is-valid') : '') ?>" placeholder="Enter username" required />
                                <?php echo ($formSubmited ? (isset($formErrors['userName']) ? '<div class="invalid-feedback">' . $formErrors['userName'] . '</div>' : '') : '') ?>
                            </div>
                            <div class="form-group">
                                <label for="emailAddress">Email*</label>
                                <input type="email" value="<?php echo ($formSubmited ? (isset($emailAddress) ? $emailAddress : '') : '') ?>" name="emailAddress" id="emailAddress" class="form-control <?php echo ($formSubmited ? (isset($formErrors['emailAddress']) ? 'is-invalid' : 'is-valid') : '') ?>" placeholder="Enter email" required />
                                <?php echo ($formSubmited ? (isset($formErrors['emailAddress']) ? '<div class="invalid-feedback">' . $formErrors['emailAddress'] . '</div>' : '') : '') ?>
                            </div>
                            <div class="form-group">
                                <label for="password">Password*</label>
                                <input type="password" value="<?php echo ($formSubmited ? (isset($password) ? $password : '') : '') ?>" name="password" id="password" class="form-control <?php echo ($formSubmited ? (isset($formErrors['password']) ? 'is-invalid' : 'is-valid') : '') ?>" placeholder="Enter password" required />
                                <?php echo ($formSubmited ? (isset($formErrors['password']) ? '<div class="invalid-feedback">' . $formErrors['password'] . '</div>' : '') : '') ?>
                            </div>
                            <div class="form-group">
                                <label for="repeatPassword">Repeat password*</label>
                                <input type="password" value="<?php echo ($formSubmited ? (isset($repeatPassword) ? $repeatPassword : '') : '') ?>" name="repeatPassword" id="repeatPassword" class="form-control <?php echo ($formSubmited ? (isset($formErrors['repeatPassword']) ? 'is-invalid' : 'is-valid') : '') ?>" placeholder="Retype password" required />
                                <?php echo ($formSubmited ? (isset($formErrors['repeatPassword']) ? '<div class="invalid-feedback">' . $formErrors['repeatPassword'] . '</div>' : '') : '') ?>
                            </div>

                            <div class="form-group">
                                <label for="city">City*</label>
                                <select name="city" id="city" class="form-control custom-select <?php echo ($formSubmited ? (isset($formErrors['city']) ? 'is-invalid' : 'is-valid') : "") ?>" required>
                                    <option value="-1">Please select city</option>
                                    <option value="1" <?php if ($_POST['city'] == '1') echo 'selected' ?>>Sofia</option>
                                    <option value="2" <?php if ($_POST['city'] == '2') echo 'selected' ?>>Varna</option>
                                    <option value="3" <?php if ($_POST['city'] == '3') echo 'selected' ?>>Plovdiv</option>
                                </select>
                                <?php echo ($formSubmited ? (isset($formErrors['city']) ? '<div class="invalid-feedback">' . $formErrors['city'] . '</div>' : '') : '') ?>
                            </div>
                            <div class="form-group">
                                <label for="address">Current address</label>
                                <input type="text" value="<?php echo ($formSubmited ? (isset($_POST['address']) ? $_POST['address'] : '') : '') ?>" name="address" id="address" class="form-control" placeholder="Enter your address" />
                            </div>
                            <div class="form-group">
                                <p>Please select your gender:</p>

                                <div class="form-check custom-control custom-radio">
                                    <input type="radio" name="gender" id="radioMale" class="custom-control-input" value="male" <?php if ($_POST['gender'] == 'male') echo 'checked' ?> />
                                    <label for="radioMale" class="custom-control-label">Male</label>

                                </div>
                                <div class="form-check custom-control custom-radio">
                                    <input type="radio" name="gender" id="radioFemale" class="custom-control-input" value="female" <?php if ($_POST['gender'] == 'female') echo 'checked' ?> />
                                    <label for="radioFemale" class="custom-control-label">Female</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="messageArea">Tell us what you think</label>
                                <textarea name="messageArea" id="messageArea" class="form-control" cols="40" rows="4" placeholder="Write your message here"><?php echo (isset($_POST['messageArea'])) ? htmlentities($_POST['messageArea']) : '' ?></textarea>
                            </div>
                            <div class="form-group custom-control custom-checkbox">
                                <input type="checkbox" name="userAgreement" id="userAgreement" class="custom-control-input <?php echo ($formSubmited ? (isset($formErrors['userAgreement']) ? 'is-invalid' : 'is-valid') : '') ?>" required <?php if (isset($_POST['userAgreement'])) echo 'checked' ?> />
                                <label for="userAgreement" class="custom-control-label"> I accept the <a href="#" class='text-secondary'>Terms and Conditions</a>
                                </label>
                                <?php echo ($formSubmited ? (isset($formErrors['userAgreement']) ? '<div class="invalid-feedback">' . $formErrors['userAgreement'] . '</div>' : '') : '') ?>
                            </div>

                            <button type="submit" class="submit-btn btn btn-secondary col-lg-4">
                                Register
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
    // Get form into $form
    $form = $('#signUpform');

    // Make validation
    $form.find('input').focusout(function() {

        if ($(this).val() != '') {
            $(this).removeClass('is-invalid');
        }

        let idValue = ($(this).attr('id'));
        switch (idValue) {
            case 'userName':
                let nameRegex = new RegExp(/^[a-zA-Z]+$/),
                    name = $(this).val();
                if (nameRegex.test(name)) {
                    $(this).addClass('is-valid');
                } else {
                    $(this).addClass('is-invalid').removeClass('is-valid').after('<div class="invalid-feedback">Letters only please!</div>');
                    if ($(this).hasClass('is-invalid')) {
                        $('div.invalid-feedback').next().remove();
                    }
                }
                break;
            case 'emailAddress':
                let emailRegex = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/),
                    email = $(this).val();
                if (emailRegex.test(email)) {
                    $(this).addClass('is-valid');
                } else {
                    $(this).addClass('is-invalid').removeClass('is-valid').after('<div class="invalid-feedback">Your email address is invalid. Please enter a valid address.</div>');
                    if ($(this).hasClass('is-invalid')) {
                        $('div.invalid-feedback').next().remove();
                    }
                }
                break;
            case 'password':
                let passwordRegex = new RegExp(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/),
                    password = $(this).val();
                if (passwordRegex.test(password)) {
                    $(this).addClass('is-valid');
                } else {
                    $(this).addClass('is-invalid').removeClass('is-valid').after('<div class="invalid-feedback">Password should be at least 8 characters in length and should include at least one upper case letter, one lowercase character and one number.</div>');
                    if ($(this).hasClass('is-invalid')) {
                        $('div.invalid-feedback').next().remove();
                    }
                }
                break;
            case 'repeatPassword':
                let originalPasword = $('#password').val(),
                    retypePassword = $(this).val();
                if (retypePassword !== originalPasword || retypePassword == '') {
                    $(this).addClass('is-invalid').removeClass('is-valid').after('<div class="invalid-feedback">Your password and confirmation password do not match.</div>');
                    if ($(this).hasClass('is-invalid')) {
                        $('div.invalid-feedback').next().remove();
                    }
                } else {
                    $(this).addClass('is-valid');
                }
                break;
            default:
        }


    });

    // Check form valid status
    function makeValidation() {
        let userName = $('#userName'),
            emailAddress = $('#emailAddress'),
            password = $('#password'),
            repeatPassword = $('#repeatPassword'),
            city = $('#city'),
            mandatoryFields = [userName, emailAddress, password, repeatPassword, city];


        $.each(mandatoryFields, function(index, value) {
            value = $(this).val();
            if (value < 1) {
                let idValue = ($(this).attr('id'));
                switch (idValue) {
                    case 'userName':
                        if (!$(this).hasClass('is-invalid')) {
                            $('#userName').addClass('is-invalid').after('<div class="invalid-feedback">Please enter your user name</div>');
                        }
                        break;
                    case 'emailAddress':
                        if (!$(this).hasClass('is-invalid')) {
                            $('#emailAddress').addClass('is-invalid').after('<div class="invalid-feedback">Please enter your email address</div>');
                        }
                        break;
                    case 'password':
                        if (!$(this).hasClass('is-invalid')) {
                            $('#password').addClass('is-invalid').after('<div class="invalid-feedback">Password should be at least 8 characters in length and should include at least one upper case letter, one lowercase character and one number.</div>');
                        }
                        break;
                    case 'repeatPassword':
                        if (!$(this).hasClass('is-invalid')) {
                            $('#repeatPassword').addClass('is-invalid').after('<div class="invalid-feedback">The field cannot be empty.</div>');
                        }
                        break;
                    case 'city':
                        if (!$(this).hasClass('is-invalid')) {
                            $('#city').addClass('is-invalid').after('<div class="invalid-feedback">Please select an option from the select box.</div>');
                        }
                        break;
                    default:
                }
                $form = false;
            } else {
                $(this).addClass('is-valid');
            }
        });

        if (!$('input:radio[name="gender"], #userAgreement').is(':checked')) {
            $('input:radio[name="gender"], #userAgreement').addClass('is-invalid');
            $('#radioFemale + label').after('<div class="invalid-feedback">Please select your gender.</div>');
            $('#userAgreement + label').after('<div class="invalid-feedback">Please indicate that you accept the Terms and Conditions.</div>');
        }
    }

    $form.find('select, input:radio, input:checkbox').change(function() {
        if ($(this).val() != '') {
            $(this).removeClass('is-invalid');
            $("input:radio[name='gender']").removeClass('is-invalid');

        }

        $('#city').change(function() {
            if ($(this).val() == '-1') {
                $(this).addClass('is-invalid').removeClass('is-valid').after('<div class="invalid-feedback">Please select an option from the drop down.</div>');
                if ($(this).hasClass('is-invalid')) {
                    $('div.invalid-feedback').next().remove();
                }
            }
        })

    });

    // Listen to form submit event
    $($form).submit(function(event) {
        makeValidation();
        if ($form == false) {
            event.preventDefault();
        }
    });
</script>
</body>

</html>