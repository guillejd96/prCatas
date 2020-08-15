package com.example.decatas;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.view.ViewCompat;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.ProtocolException;
import java.net.URL;
import java.net.URLEncoder;
import java.util.LinkedHashMap;
import java.util.Map;

public class Login extends AppCompatActivity {

    EditText inputPassword,inputUser;
    TextView res;
    public static final int CONNECTION_TIMEOUT = 10000;
    public static final int READ_TIMEOUT = 15000;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        inputPassword = (EditText)findViewById(R.id.password);
        inputUser = (EditText)findViewById(R.id.user);
        res = (TextView) findViewById(R.id.res);

        inputUser.setBackgroundResource(R.drawable.input_normal);
        inputPassword.setBackgroundResource(R.drawable.input_normal);

        inputUser.setText("");
        inputPassword.setText("");
    }

     public void btnLogin(View view) throws MalformedURLException {
         inputUser.setBackgroundResource(R.drawable.input_normal);
         inputPassword.setBackgroundResource(R.drawable.input_normal);
         String enteredUsername = inputUser.getText().toString();
         String enteredPassword = inputPassword.getText().toString();

         if(TextUtils.isEmpty(enteredUsername) || TextUtils.isEmpty(enteredPassword)){
             Toast.makeText(getApplicationContext(),R.string.empty_login_input,Toast.LENGTH_SHORT).show();
             inputUser.setBackgroundResource(R.drawable.input_error);
             inputPassword.setBackgroundResource(R.drawable.input_error);
             return;
         } else {
             Map<String,String> params = new LinkedHashMap<>();
             params.put("user",enteredUsername);
             params.put("pass",enteredPassword);
             Connection con = new Connection(getApplicationContext(),"login.php",params);
             while(con.getRes()==null);
             String res = con.getRes().toString();
             if(!res.equals("0")){
                 String idUsuario = res.toString();
                 Intent intent = new Intent(getApplicationContext(), User.class);
                 intent.putExtra("id", idUsuario);
                 startActivity(intent);
             }else {
                 inputUser.setBackgroundResource(R.drawable.input_error);
                 inputPassword.setBackgroundResource(R.drawable.input_error);
                 Toast.makeText(getApplicationContext(),R.string.login_failed,Toast.LENGTH_LONG).show();
             }
         }
     }

     public void newUser(View view){
         Intent intent = new Intent(getApplicationContext(),Nuevo_Usuario.class);
         startActivity(intent);
     }

     public void instructions(View view){
         Intent intent = new Intent(getApplicationContext(),Instrucciones.class);
         startActivity(intent);
     }

    public void goToContacto(View v){
        Intent intent = new Intent(getApplicationContext(),Contacto.class);
        startActivity(intent);
    }

    public void goToFaq(View v){
        Intent intent = new Intent(getApplicationContext(),Faq.class);
        startActivity(intent);
    }

    @Override
    public void onRestart() {
        super.onRestart();
        finish();
        startActivity(getIntent());
    }
}
