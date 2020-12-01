const copyButton = document.querySelector('#copy');

copyButton.addEventListener('click', e => {
  e.preventDefault();
  const copyText = document.querySelector(".copy-text");
  copyText.select();
  document.execCommand("copy");
})