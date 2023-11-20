function generatePassword() {
    var pass = '';
    var str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' + 'abcdefghijklmnopqrstuvwxyz0123456789@#$';

    for (i = 1; i <= 9; i++) {
        var char = Math.floor(Math.random() *
            str.length + 1);

        pass += str.charAt(char);
    }
    console.log(pass);
    return pass;
}