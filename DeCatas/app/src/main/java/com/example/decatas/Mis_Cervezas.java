package com.example.decatas;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.graphics.Paint;
import android.graphics.Typeface;
import android.os.Bundle;

import androidx.appcompat.app.AppCompatActivity;

import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.net.MalformedURLException;
import java.util.Arrays;
import java.util.LinkedHashMap;
import java.util.Map;

public class Mis_Cervezas extends AppCompatActivity {

    private String idUsuario;
    public LinearLayout layout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_mis_cervezas);

        Bundle bundle = getIntent().getExtras();
        idUsuario = bundle.getString("id");

        this.layout = findViewById(R.id.layout);

        update();
    }

    public void update(){
        layout.removeAllViews();
        Map<String,String> params = new LinkedHashMap<>();
        params.put("id",idUsuario);

        TextView first_label = new TextView(this);
        first_label.setLayoutParams(new TableRow.LayoutParams(
                TableRow.LayoutParams.FILL_PARENT,
                TableRow.LayoutParams.WRAP_CONTENT
        ));
        first_label.setGravity(Gravity.CENTER);
        first_label.setPadding(10,10,10,10);
        first_label.setTextSize(20);
        first_label.setVisibility(View.VISIBLE);
        first_label.setText(getResources().getString(R.string.label_delete_beer));
        layout.addView(first_label);

        try {
            Connection con = new Connection(getApplicationContext(),"getCervezas.php",params);
            while(con.getRes()==null);
            String result = con.getRes();
            if(result.equals("IOException")){
                Toast.makeText(this, R.string.error_connecting, Toast.LENGTH_SHORT).show();
            }else if(!result.equals("")){

                String[] cervezas = result.split(";");

                if(cervezas.length>0){
                    for(String c : cervezas){
                        String[] atribs = c.split(",");
                        if(atribs.length>1){
                            final String idCerveza = atribs[0];
                            Log.v("ID DE CERVEZA ",idCerveza);
                            String nombre = atribs[1];
                            String aroma = atribs[2];
                            String apariencia = atribs[3];
                            String sabor = atribs[4];
                            String cuerpo = atribs[5];
                            String botellin = atribs[6];

                            TextView tv = new TextView(this);
                            tv.setLayoutParams(new TableRow.LayoutParams(
                                    TableRow.LayoutParams.FILL_PARENT,
                                    TableRow.LayoutParams.WRAP_CONTENT
                            ));
                            tv.setTypeface(Typeface.DEFAULT,Typeface.BOLD);
                            tv.setGravity(Gravity.CENTER);
                            tv.setPadding(10,10,10,10);
                            tv.setTextSize(22);
                            tv.setVisibility(View.VISIBLE);
                            tv.setText(nombre);
                            tv.setPaintFlags(tv.getPaintFlags() | Paint.UNDERLINE_TEXT_FLAG);
                            Map<String,String> p = new LinkedHashMap<>();
                            p.put("id",idCerveza);
                            Connection conn = new Connection(this,"getCataDesdeCerveza.php",p);
                            while(conn.getRes()==null);
                            String res = conn.getRes();
                            if(res.equals("IOException")){
                                Toast.makeText(this, R.string.error_connecting, Toast.LENGTH_SHORT).show();
                            }else if(res.equals("")){
                                Delete d = new Delete(idCerveza);
                                tv.setOnClickListener(d);
                            }else {
                                tv.setOnClickListener(new View.OnClickListener() {
                                    @Override
                                    public void onClick(View v) {
                                        android.app.AlertDialog.Builder builder = new AlertDialog.Builder(Mis_Cervezas.this);
                                        builder.setCancelable(true);
                                        builder.setMessage(R.string.cant_delete_beer);
                                        builder.show();
                                    }
                                });
                            }
                            layout.addView(tv);


                            tv = new TextView(this);
                            tv.setLayoutParams(new TableRow.LayoutParams(
                                    TableRow.LayoutParams.FILL_PARENT,
                                    TableRow.LayoutParams.WRAP_CONTENT
                            ));
                            tv.setGravity(Gravity.CENTER);
                            tv.setPadding(10,10,10,10);
                            tv.setTextSize(20);
                            tv.setVisibility(View.VISIBLE);
                            tv.setText(getResources().getString(R.string.label_smell)+" "+aroma);
                            layout.addView(tv);

                            tv = new TextView(this);
                            tv.setLayoutParams(new TableRow.LayoutParams(
                                    TableRow.LayoutParams.FILL_PARENT,
                                    TableRow.LayoutParams.WRAP_CONTENT
                            ));
                            tv.setGravity(Gravity.CENTER);
                            tv.setPadding(10,10,10,10);
                            tv.setTextSize(20);
                            tv.setVisibility(View.VISIBLE);
                            tv.setText(getResources().getString(R.string.label_appearance)+" "+apariencia);
                            layout.addView(tv);

                            tv = new TextView(this);
                            tv.setLayoutParams(new TableRow.LayoutParams(
                                    TableRow.LayoutParams.FILL_PARENT,
                                    TableRow.LayoutParams.WRAP_CONTENT
                            ));
                            tv.setGravity(Gravity.CENTER);
                            tv.setPadding(10,10,10,10);
                            tv.setTextSize(20);
                            tv.setVisibility(View.VISIBLE);
                            tv.setText(getResources().getString(R.string.label_taste)+" "+sabor);
                            layout.addView(tv);

                            tv = new TextView(this);
                            tv.setLayoutParams(new TableRow.LayoutParams(
                                    TableRow.LayoutParams.FILL_PARENT,
                                    TableRow.LayoutParams.WRAP_CONTENT
                            ));
                            tv.setGravity(Gravity.CENTER);
                            tv.setPadding(10,10,10,10);
                            tv.setTextSize(20);
                            tv.setVisibility(View.VISIBLE);
                            tv.setText(getResources().getString(R.string.label_body)+" "+cuerpo);
                            layout.addView(tv);

                            tv = new TextView(this);
                            tv.setLayoutParams(new TableRow.LayoutParams(
                                    TableRow.LayoutParams.FILL_PARENT,
                                    TableRow.LayoutParams.WRAP_CONTENT
                            ));
                            tv.setGravity(Gravity.CENTER);
                            tv.setPadding(10,10,10,10);
                            tv.setTextSize(20);
                            tv.setVisibility(View.VISIBLE);
                            tv.setText(getResources().getString(R.string.label_bottle)+" "+botellin);
                            layout.addView(tv);
                        }
                    }
                    TextView tv = new TextView(this);
                    tv.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));
                    tv.setGravity(Gravity.CENTER);
                    tv.setPadding(10,10,10,10);
                    tv.setTextSize(20);
                    tv.setVisibility(View.VISIBLE);
                    tv.setText("");
                    layout.addView(tv);
                }
            }else{
                TextView tv = new TextView(this);
                tv.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tv.setGravity(Gravity.CENTER);
                tv.setVisibility(View.VISIBLE);
                tv.setPadding(10,10,10,10);
                tv.setTextSize(20);
                tv.setText(R.string.no_beers_found);

                layout.addView(tv);
            }
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }
    }

    private class Delete implements View.OnClickListener {

        public String idCerveza;

        public Delete(String s){
            this.idCerveza=s;
        }

        @Override
        public void onClick(View v) {
            android.app.AlertDialog.Builder builder = new AlertDialog.Builder(Mis_Cervezas.this);
            builder.setCancelable(true);
            builder.setMessage(getResources().getString(R.string.question_delete_beer));
            builder.setPositiveButton(R.string.ok, new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    Map<String,String> params = new LinkedHashMap<>();
                    params.put("id",idCerveza);
                    try {
                        Connection con = new Connection(Mis_Cervezas.this,"deleteCerveza.php",params);
                        while(con.getRes()==null);
                        String result = con.getRes();
                        if(result.equals("IOException")){
                            OutputStreamWriter outputStreamWriter = null;
                            if(!Arrays.asList(fileList()).contains("requests.txt")) {
                                new File(getFilesDir(), "requests.txt");
                                outputStreamWriter = new OutputStreamWriter(openFileOutput("requests.txt", Context.MODE_PRIVATE));
                            }else {
                                outputStreamWriter = new OutputStreamWriter(openFileOutput("requests.txt", Context.MODE_APPEND));
                            }
                            outputStreamWriter.write("deleteCerveza.php;"+idCerveza+"/");
                            outputStreamWriter.close();

                            android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(Mis_Cervezas.this);
                            builder.setCancelable(true);
                            builder.setTitle(R.string.error_connecting);
                            builder.setMessage(R.string.ioexception_message);
                            builder.show();
                        }else {
                            update();
                        }
                    } catch (MalformedURLException e) {
                        e.printStackTrace();
                    } catch (FileNotFoundException e) {
                        e.printStackTrace();
                    } catch (IOException e) {
                        e.printStackTrace();
                    }
                }
            });
            builder.setNegativeButton(R.string.cancel, null);
            builder.show();
        }
    }
}