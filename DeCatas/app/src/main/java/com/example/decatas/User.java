package com.example.decatas;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.view.KeyEvent;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import java.net.MalformedURLException;
import java.util.LinkedHashMap;
import java.util.Map;
import java.util.Scanner;

public class User extends AppCompatActivity {

    private String idUsuario;
    public TextView textUsuario,textNombre,textCatas,textCervezas,textAmigos;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_user);

        Bundle bundle = getIntent().getExtras();
        idUsuario = bundle.getString("id");

        textUsuario = (TextView)findViewById(R.id.textUsuario);
        textNombre = (TextView)findViewById(R.id.textNombre);
        textCatas = (TextView)findViewById(R.id.textCatas);
        textCervezas = (TextView)findViewById(R.id.textCervezas);
        textAmigos = (TextView)findViewById(R.id.textAmigos);

        Map<String,String> params = new LinkedHashMap<>();
        params.put("id",idUsuario);
        try {
            Connection con = new Connection(getApplicationContext(),"getUser.php",params);
            while(con.getRes()==null);
            String res = con.getRes().toString();
            if(!res.equals("0")){
                String[] resArray = res.split(";");
                textUsuario.setText(resArray[0]);
                textNombre.setText(resArray[1]);
                textCatas.setText(resArray[2]);
                textCervezas.setText(resArray[3]);
                textAmigos.setText(resArray[4]);
            } else {
                Toast.makeText(getApplicationContext(),R.string.login_failed,Toast.LENGTH_LONG);
            }
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }
    }

    public void goToNuevaCerveza(View v){
        Intent intent = new Intent(getApplicationContext(),Nueva_Cerveza.class);
        intent.putExtra("id", idUsuario);
        startActivity(intent);
    }

    public void goToMisCervezas(View v){
        Intent intent = new Intent(getApplicationContext(),Mis_Cervezas.class);
        intent.putExtra("id", idUsuario);
        startActivity(intent);
    }

    public void goToNuevaCata(View v){
        Intent intent = new Intent(getApplicationContext(),Nueva_Cata.class);
        intent.putExtra("id", idUsuario);
        startActivity(intent);
    }

    public void goToUnirseACata(View v){
        Intent intent = new Intent(getApplicationContext(),Buscar_Cata.class);
        intent.putExtra("id", idUsuario);
        startActivity(intent);
    }

    public void goToMisCatas(View v){
        Intent intent = new Intent(getApplicationContext(),Mis_Catas.class);
        intent.putExtra("id", idUsuario);
        startActivity(intent);
    }

    @Override
    public void onRestart() {
        super.onRestart();
        finish();
        startActivity(getIntent());
    }

    @Override
    public void onBackPressed() {
        android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(User.this);
        builder.setCancelable(true);
        builder.setMessage(getResources().getString(R.string.question_exit_user));
        builder.setPositiveButton(R.string.ok, new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.dismiss();
                Intent intent = new Intent(getApplicationContext(),Login.class);
                startActivity(intent);
            }
        });
        builder.setNegativeButton(R.string.cancel, null);
        builder.show();
    }
}