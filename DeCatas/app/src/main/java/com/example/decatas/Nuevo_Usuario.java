package com.example.decatas;

import android.content.Intent;
import android.os.Build;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;

import android.text.Html;
import android.text.Spanned;
import android.text.TextUtils;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.Toast;

import java.io.IOException;
import java.net.MalformedURLException;
import java.util.LinkedHashMap;
import java.util.Map;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class Nuevo_Usuario extends AppCompatActivity {

    EditText inputUser, inputName, inputPass1, inputPass2;
    Button btnCreateUser;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_nuevo_usuario);

        inputUser = findViewById(R.id.user);
        inputName = findViewById(R.id.name);
        inputPass1 = findViewById(R.id.pass1);
        inputPass2 = findViewById(R.id.pass2);
        btnCreateUser = findViewById(R.id.btnCreateUser);


        btnCreateUser.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                try {
                    saveNewUser();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }
        });
    }

    private static boolean checkUser(String s){
        return TextUtils.isEmpty(s);
    }


    private static boolean checkUserLength(String s){
        return s.length()<=8;
    }

    private static boolean checkName(String s){
        return TextUtils.isEmpty(s);
    }

    private static boolean checkPasswords(String p1,String p2){
        return p1.equals(p2);
    }

    private static boolean checkPassword(String p){
        return TextUtils.isEmpty(p);
    }

    private boolean checkExistUser(String s) throws MalformedURLException {
        Map<String,String> params = new LinkedHashMap<>();
        params.put("u",s);
        Connection con = new Connection(getApplicationContext(),"existeUsuario.php",params);
        while(con.getRes()==null);
        String res = con.getRes();
        if(res.equals("IOException")){
            Toast.makeText(this, R.string.error_connecting, Toast.LENGTH_LONG).show();
            return true;
        }else return res.equals("0");
    }

    private static boolean checkSecurityPassword(String s){
        return isValidPassword(s);
    }

    private  static boolean isValidPassword(String password){
        Pattern pattern = Pattern.compile("^(?=.*\\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$");
        Matcher matcher = pattern.matcher(password);
        return matcher.matches();
    }

    private void saveNewUser() throws IOException {
        inputPass1.setBackgroundResource(R.drawable.input_error);
        inputPass2.setBackgroundResource(R.drawable.input_error);
        inputUser.setBackgroundResource(R.drawable.input_normal);
        inputName.setBackgroundResource(R.drawable.input_normal);

        String newUser = inputUser.getText().toString();
        String newName = inputName.getText().toString();
        String newPass1 = inputPass1.getText().toString();
        String newPass2 = inputPass2.getText().toString();

        if(checkUser(newUser)){
            inputUser.setBackgroundResource(R.drawable.input_error);
            Toast.makeText(getApplicationContext(),R.string.empty_user,Toast.LENGTH_LONG).show();
        } else if(!checkUserLength(newUser)){
            Toast.makeText(getApplicationContext(), R.string.error_length_user,Toast.LENGTH_LONG).show();
            inputUser.setBackgroundResource(R.drawable.input_error);
        } else if(!checkExistUser(newUser)){
            Toast.makeText(getApplicationContext(),R.string.user_exists,Toast.LENGTH_LONG).show();
            inputUser.setBackgroundResource(R.drawable.input_error);
        } else if(checkName(newName)){
            Toast.makeText(getApplicationContext(),R.string.empty_name,Toast.LENGTH_LONG).show();
            inputName.setBackgroundResource(R.drawable.input_error);
        } else if(checkPassword(newPass1)||checkPassword(newPass2)){
            Toast.makeText(getApplicationContext(),R.string.empty_pass,Toast.LENGTH_LONG).show();
            inputPass1.setBackgroundResource(R.drawable.input_error);
            inputPass2.setBackgroundResource(R.drawable.input_error);
        } else if(!checkSecurityPassword(newPass1)){
            Toast.makeText(getApplicationContext(),R.string.password_not_secure,Toast.LENGTH_LONG).show();
            inputPass1.setBackgroundResource(R.drawable.input_error);
            inputPass2.setBackgroundResource(R.drawable.input_error);
        } else if(!checkPasswords(newPass1,newPass2)){
            Toast.makeText(getApplicationContext(),R.string.different_pass,Toast.LENGTH_LONG).show();
            inputPass1.setBackgroundResource(R.drawable.input_error);
            inputPass2.setBackgroundResource(R.drawable.input_error);
        } else {
            inputPass1.setBackgroundResource(R.drawable.input_error);
            inputPass2.setBackgroundResource(R.drawable.input_error);
            inputUser.setBackgroundResource(R.drawable.input_normal);
            inputName.setBackgroundResource(R.drawable.input_normal);
            Map<String,String> params = new LinkedHashMap<>();
            params.put("usuario",newUser);
            params.put("nombre",newName);
            params.put("contrasenya",newPass1);
            Connection con = new Connection(getApplicationContext(),"nuevoUsuario.php",params);
            while(con.getRes()==null);
            String res = con.getRes();
            if(res.equals("IOException")){
                Toast.makeText(this, R.string.error_connecting, Toast.LENGTH_LONG).show();
            }else if(res.equals("1")){
                Intent intent = new Intent(getApplicationContext(),Login.class);
                startActivity(intent);
            }else {
                Toast.makeText(getApplicationContext(), R.string.error_inserting,Toast.LENGTH_LONG).show();
            }
        }
    }

    private Spanned getSpannedText(String text) {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.N) {
            return Html.fromHtml(text, Html.FROM_HTML_MODE_COMPACT);
        } else {
            return Html.fromHtml(text);
        }
    }

    public void infoName(View v){
        android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(Nuevo_Usuario.this);
        builder.setCancelable(true);
        builder.setMessage(getResources().getString(R.string.info_name));
        builder.show();
    }

    public void infoPass(View v){
        android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(Nuevo_Usuario.this);
        builder.setCancelable(true);
        builder.setMessage(getSpannedText(getResources().getString(R.string.info_pass)));
        builder.show();
    }
}
