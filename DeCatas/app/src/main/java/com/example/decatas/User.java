package com.example.decatas;

import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.Paint;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;

import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import java.net.MalformedURLException;
import java.util.LinkedHashMap;
import java.util.Map;

public class User extends AppCompatActivity {

    private String idUsuario;
    public TextView textUsuario,textNombre,textCatas,textCervezas,textAmigos,requests;
    public ConstraintLayout layout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_user);

        Bundle bundle = getIntent().getExtras();
        idUsuario = bundle.getString("id");

        textUsuario = findViewById(R.id.textUsuario);
        textNombre = findViewById(R.id.textNombre);
        textCatas = findViewById(R.id.textCatas);
        textCervezas = findViewById(R.id.textCervezas);
        textAmigos = findViewById(R.id.textAmigos);
        requests = findViewById(R.id.requests);

        Map<String,String> params = new LinkedHashMap<>();
        params.put("id",idUsuario);
        Connection con = null;

        try {
            con = new Connection(getApplicationContext(),"getUser.php",params);
            while(con.getRes()==null);
            String res = con.getRes();
            if(!res.equals("0")){
                String[] resArray = res.split(";");
                textUsuario.setText(resArray[0]);
                textNombre.setText(resArray[1]);
                textCatas.setText(resArray[2]);
                textCervezas.setText(resArray[3]);
                textAmigos.setText(resArray[4]);
            } else {
                Toast.makeText(getApplicationContext(),R.string.login_failed,Toast.LENGTH_LONG).show();
            }

            con = new Connection(getApplicationContext(),"checkSolicitudes.php",params);
            while(con.getRes()==null);
            res = con.getRes();
            if(res.equals("1")){
                requests.setPadding(10,10,10,10);
                requests.setTextSize(20);
                requests.setText(R.string.exist_request);
                requests.setTextColor(Color.BLUE);
                requests.setPaintFlags(requests.getPaintFlags()| Paint.UNDERLINE_TEXT_FLAG);
                requests.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        Intent intent = new Intent(getApplicationContext(),Solicitudes.class);
                        intent.putExtra("id", idUsuario);
                        startActivity(intent);
                    }
                });
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

    public void goToMisAmigos(View v){
        Intent intent = new Intent(getApplicationContext(),Mis_Amigos.class);
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