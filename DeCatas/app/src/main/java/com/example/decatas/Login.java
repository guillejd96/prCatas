package com.example.decatas;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.view.inputmethod.InputMethodManager;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.view.ViewCompat;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.ProtocolException;
import java.net.URL;
import java.net.URLEncoder;
import java.util.Arrays;
import java.util.LinkedHashMap;
import java.util.Map;

public class Login extends AppCompatActivity {

    EditText inputPassword,inputUser;
    TextView res;
    CheckBox checkBox;
    private boolean autologin;
    public static final int CONNECTION_TIMEOUT = 10000;
    public static final int READ_TIMEOUT = 15000;

    @RequiresApi(api = Build.VERSION_CODES.KITKAT)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);

        inputPassword = (EditText)findViewById(R.id.password);
        inputUser = (EditText)findViewById(R.id.user);
        res = (TextView) findViewById(R.id.res);
        checkBox = (CheckBox) findViewById(R.id.check);

        inputUser.setBackgroundResource(R.drawable.input_normal);
        inputPassword.setBackgroundResource(R.drawable.input_normal);

        inputUser.setText("");
        inputPassword.setText("");

        Intent i = getIntent();
        if (i.hasExtra("autologin")) {
            String s = i.getExtras().getString("autologin");
            if(s.equals("0")) this.autologin = false;
            else this.autologin = true;
        } else {
            this.autologin = true;
        }

        if(Arrays.asList(fileList()).contains("login.txt") && autologin){
            try {
                FileInputStream login = openFileInput("login.txt");
                InputStreamReader isr = new InputStreamReader(login);
                BufferedReader bufferedReader = new BufferedReader(isr);
                StringBuilder sb = new StringBuilder();
                String line;
                while ((line = bufferedReader.readLine()) != null) {
                    sb.append(line);
                }
                bufferedReader.close();

                String[] aux = sb.toString().split(";");
                String user = aux[0];
                String pass = aux[1];

                Map<String,String> params = new LinkedHashMap<>();
                params.put("user",user);
                params.put("pass",pass);
                Connection con = new Connection(getApplicationContext(),"login.php",params);
                while(con.getRes()==null);
                String res = con.getRes();
                if(!res.equals("IOException")){
                    String idUsuario = res;
                    Intent intent = new Intent(getApplicationContext(), User.class);
                    intent.putExtra("id", idUsuario);
                    startActivity(intent);
                }else {
                    Toast.makeText(this, R.string.error_connecting, Toast.LENGTH_SHORT).show();
                }
            } catch (FileNotFoundException e) {
                e.printStackTrace();
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
    }

     public void btnLogin(View view) throws IOException {
         inputUser.setBackgroundResource(R.drawable.input_normal);
         inputPassword.setBackgroundResource(R.drawable.input_normal);
         String enteredUsername = inputUser.getText().toString();
         String enteredPassword = inputPassword.getText().toString();

         closeKeyboard();

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
             String res = con.getRes();
             if(res.equals("IOException")){
                 Toast.makeText(this, R.string.error_connecting, Toast.LENGTH_SHORT).show();
             }else if(res.equals("0")){
                 inputUser.setBackgroundResource(R.drawable.input_error);
                 inputPassword.setBackgroundResource(R.drawable.input_error);
                 Toast.makeText(getApplicationContext(),R.string.login_failed,Toast.LENGTH_LONG).show();
             } else {
                 String idUsuario = res;

                 if(checkBox.isChecked()){
                     if(Arrays.asList(fileList()).contains("login.txt")){
                         deleteFile("login.txt");
                     }
                     new File(getFilesDir(), "login.txt");
                     OutputStreamWriter outputStreamWriter = new OutputStreamWriter(openFileOutput("login.txt", Context.MODE_PRIVATE));
                     outputStreamWriter.write(enteredUsername+";"+enteredPassword);
                     outputStreamWriter.close();
                 }

                 Intent intent = new Intent(getApplicationContext(), User.class);
                 intent.putExtra("id", idUsuario);
                 startActivity(intent);
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

    private void closeKeyboard(){
        View v = this.getCurrentFocus();
        if(v!=null){
            InputMethodManager imm = (InputMethodManager)getSystemService(Context.INPUT_METHOD_SERVICE);
            imm.hideSoftInputFromWindow(v.getWindowToken(),0);
        }
    }

    @Override
    public void onRestart() {
        super.onRestart();
        finish();
        startActivity(getIntent());
    }
}
