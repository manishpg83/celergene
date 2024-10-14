/**
 * Account Settings - Account
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        const deactivateAcc = document.querySelector('#formAccountDeactivation'),
            deactivateButton = deactivateAcc.querySelector('.deactivate-account');

        if (deactivateAcc) {
            const fv = FormValidation.formValidation(deactivateAcc, {
                fields: {
                    accountActivation: {
                        validators: {
                            notEmpty: {
                                message: 'Please confirm you want to delete account'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: ''
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    fieldStatus: new FormValidation.plugins.FieldStatus({
                        onStatusChanged: function (areFieldsValid) {
                            areFieldsValid
                                ? deactivateButton.removeAttribute('disabled')
                                : deactivateButton.setAttribute('disabled', 'disabled');
                        }
                    }),
                    autoFocus: new FormValidation.plugins.AutoFocus()
                },
                init: instance => {
                    instance.on('plugins.message.placed', function (e) {
                        if (e.element.parentElement.classList.contains('input-group')) {
                            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                        }
                    });
                }
            });
        }

        // Deactivate account alert
        const accountActivation = document.querySelector('#accountActivation');

        if (deactivateButton) {
            deactivateButton.onclick = function () {
                if (accountActivation.checked) {
                    Swal.fire({
                        text: 'Are you sure you would like to deactivate your account?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        customClass: {
                            confirmButton: 'btn btn-primary me-2 waves-effect waves-light',
                            cancelButton: 'btn btn-label-secondary waves-effect waves-light'
                        },
                        buttonsStyling: false
                    }).then(function (result) {
                        if (result.value) {
                            // Make the DELETE request
                            $.ajax({
                                url: '/admin/profile/delete', // Your Laravel route for account deletion
                                type: 'DELETE',
                                data: {
                                    _token: '{{ csrf_token() }}' // Include CSRF token
                                },
                                success: function (response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: 'Your account has been deleted.',
                                        customClass: {
                                            confirmButton: 'btn btn-success waves-effect waves-light'
                                        }
                                    }).then(() => {
                                        window.location.href = '{{ route("admin.login") }}'; // Redirect to admin login page
                                    });
                                },
                                error: function () {
                                    Swal.fire({
                                        title: 'Error',
                                        text: 'There was an error deactivating your account.',
                                        icon: 'error',
                                        customClass: {
                                            confirmButton: 'btn btn-danger waves-effect waves-light'
                                        }
                                    });
                                }
                            });
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire({
                                title: 'Cancelled',
                                text: 'Deactivation Cancelled!!',
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-success waves-effect waves-light'
                                }
                            });
                        }
                    });
                }
            };
        }
    })();


    // CleaveJS validation

    const phoneNumber = document.querySelector('#phoneNumber'),
      zipCode = document.querySelector('#zipCode');
    // Phone Mask
    if (phoneNumber) {
      new Cleave(phoneNumber, {
        phone: true,
        phoneRegionCode: 'US'
      });
    }

    // Pincode
    if (zipCode) {
      new Cleave(zipCode, {
        delimiter: '',
        numeral: true
      });
    }

    // Update/reset user image of account page
    let accountUserImage = document.getElementById('uploadedAvatar');
    const fileInput = document.querySelector('.account-file-input'),
      resetFileInput = document.querySelector('.account-image-reset');

    if (accountUserImage) {
      const resetImage = accountUserImage.src;
      fileInput.onchange = () => {
        if (fileInput.files[0]) {
          accountUserImage.src = window.URL.createObjectURL(fileInput.files[0]);
        }
      };
      resetFileInput.onclick = () => {
        fileInput.value = '';
        accountUserImage.src = resetImage;
      };
    }
  })();
});

// Select2 (jquery)
$(function () {
  var select2 = $('.select2');
  // For all Select2
  if (select2.length) {
    select2.each(function () {
      var $this = $(this);
      $this.wrap('<div class="position-relative"></div>');
      $this.select2({
        dropdownParent: $this.parent()
      });
    });
  }
});
