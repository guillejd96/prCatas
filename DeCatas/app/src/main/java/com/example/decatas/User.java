package com.example.decatas;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.Paint;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;
import androidx.constraintlayout.widget.ConstraintLayout;

import android.util.Log;
import android.view.View;
import android.widget.TextView;
import android.widget.Toast;

import java.io.BufferedReader;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.net.MalformedURLException;
import java.util.Arrays;
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

        boolean checked = false;
        try {
            if(checkRequests()) checked=true;
            else checked=false;
        } catch (IOException e) {
            e.printStackTrace();
        }

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

        if (checked) {
            android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(User.this);
            builder.setCancelable(true);
            builder.setMessage(R.string.insert_requests_successfully);
            builder.show();
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
                intent.putExtra("autologin","0");
                startActivity(intent);
            }
        });
        builder.setNegativeButton(R.string.cancel, null);
        builder.show();
    }

    private boolean checkRequests() throws IOException {
        boolean b = false;
        if(Arrays.asList(fileList()).contains("requests.txt")){
            b = true;
            FileInputStream r = openFileInput("requests.txt");
            InputStreamReader isr = new InputStreamReader(r);
            BufferedReader bufferedReader = new BufferedReader(isr);
            StringBuilder sb = new StringBuilder();
            String line;
            while ((line = bufferedReader.readLine()) != null) {
                sb.append(line);
            }
            bufferedReader.close();

            String[] requests = sb.toString().split("/");
            for(String re : requests){
                String[] infoRequest = re.split(";");
                String file = infoRequest[0];
                String infoData = infoRequest[1];
                String data[] = infoData.split(",");
                Map<String,String> params = new LinkedHashMap<>();
                if(file.equals("nuevaCervezaIndividual.php")){
                    params.put("id",idUsuario);
                    params.put("n",data[0]);
                    params.put("ar",data[1]);
                    params.put("ap",data[2]);
                    params.put("s",data[3]);
                    params.put("c",data[4]);
                    params.put("b",data[5]);
                }

                Connection con = new Connection(this,file,params);
                while(con.getRes()==null);
                String res = con.getRes();
                if(res.equals("IOException") || !res.equals("1")){
                    b=false;
                } else {
                    deleteRequestFromFile(requests,re);
                }
            }
            if(b) deleteFile("requests.txt");
        }
        return b;
    }

    private void deleteRequestFromFile(String[] requests, String re) throws IOException {
        String result= "";
        OutputStreamWriter outputStreamWriter = new OutputStreamWriter(openFileOutput("requests.txt", Context.MODE_PRIVATE));
        for(String r : requests){
            if(!r.equals(re)){
                result+=r;
            }
        }
        outputStreamWriter.write(result);
        outputStreamWriter.close();
    }
}