package com.example.decatas;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.text.InputType;
import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TableLayout;
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

public class Mis_Catas extends AppCompatActivity {

    private String idUsuario;
    public TableLayout table;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_mis__catas);

        Bundle bundle = getIntent().getExtras();
        idUsuario = bundle.getString("id");

        table = (TableLayout)findViewById(R.id.table);

        this.update();
    }

    public void update(){
        table.removeAllViews();
        Map<String,String> params = new LinkedHashMap<>();
        params.put("u",idUsuario);
        Connection con = null;
        try {
            con = new Connection(this,"getCatas.php",params);
            while(con.getRes()==null);
            String result = con.getRes();
            if(!result.equals("")){
                String[] aux = result.split(";");

                TableRow trTH = new TableRow(this);

                trTH.setGravity(Gravity.CENTER);
                trTH.setBackgroundResource(R.drawable.border);
                trTH.setPadding(10,10,10,10);

                trTH.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT));

                trTH.setVisibility(View.VISIBLE);

                int[] labels = {R.string.name,R.string.date, R.string.admin};
                int i=0;

                TextView[] rowTextView1 = new TextView[3];
                for(TextView tv : rowTextView1){
                    tv = new TextView(this);
                    tv.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));
                    tv.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
                    tv.setGravity(Gravity.CENTER);
                    tv.setVisibility(View.VISIBLE);
                    tv.setPadding(10,10,10,10);
                    tv.setTextSize(17);
                    tv.setText(labels[i]);
                    i++;
                    trTH.addView(tv);
                }

                ImageView icon1 = new ImageView(this);
                icon1.setBackgroundResource(R.drawable.ic_people_foreground);
                icon1.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                icon1.getLayoutParams().height=100;
                icon1.getLayoutParams().width=100;
                icon1.setVisibility(View.VISIBLE);
                trTH.addView(icon1);

                ImageView icon2 = new ImageView(this);
                icon2.setBackgroundResource(R.drawable.ic_beer_foreground);
                icon2.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                icon2.getLayoutParams().height=100;
                icon2.getLayoutParams().width=100;
                icon2.setVisibility(View.VISIBLE);
                trTH.addView(icon2);

                TextView tr = new TextView(this);
                tr.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tr.setGravity(Gravity.CENTER);
                tr.setVisibility(View.VISIBLE);
                tr.setPadding(10,10,10,10);
                tr.setTextSize(17);
                trTH.addView(tr);

                table.addView(trTH);

                for(String cata : aux){
                    String[] aux2 = cata.split(",");
                    final String idCata = aux2[0];
                    String nombreCata = aux2[1];
                    String fechaCata = aux2[2];
                    String en_cursoCata = aux2[3];
                    String idAdminCata = aux2[4];

                    TableRow trTD = new TableRow(this);

                    trTD.setGravity(Gravity.CENTER);
                    trTD.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.WRAP_CONTENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTD.setVisibility(View.VISIBLE);
                    trTD.setBackgroundResource(R.drawable.border);

                    TextView[] rowTextView2 = new TextView[5];

                    Map<String,String> params2 = new LinkedHashMap<>();
                    params2.put("id",idCata);
                    Connection conn = new Connection(this,"getNPersonas.php",params2);
                    while (conn.getRes()==null);
                    String nPersonas =conn.getRes();

                    Map<String,String> params3 = new LinkedHashMap<>();
                    params3.put("id",idCata);
                    Connection conn2 = new Connection(this,"getNCervezas.php",params3);
                    while (conn2.getRes()==null);
                    String nCervezas = conn2.getRes();

                    String admin;
                    boolean isAdmin=false;

                    if(idUsuario.equals(idAdminCata)){
                        admin = getResources().getString(R.string.you);
                        isAdmin=true;
                    }else {
                        Map<String,String> params4 = new LinkedHashMap<>();
                        params4.put("id",idAdminCata);
                        Connection conn3 = new Connection(this,"getAdmin.php",params4);
                        while (conn3.getRes()==null);
                        admin = conn3.getRes();
                    }

                    String[] labelS = {nombreCata,fechaCata,admin,nPersonas,nCervezas};
                    int j=0;

                    for(TextView tv : rowTextView2){
                        tv = new TextView(this);
                        tv.setLayoutParams(new TableRow.LayoutParams(
                                TableRow.LayoutParams.WRAP_CONTENT,
                                TableRow.LayoutParams.WRAP_CONTENT
                        ));
                        tv.setGravity(Gravity.CENTER);
                        tv.setPadding(10,10,10,10);
                        tv.setTextSize(17);
                        tv.setVisibility(View.VISIBLE);
                        tv.setText(labelS[j]);
                        j++;
                        trTD.addView(tv);
                    }

                    if(isAdmin){
                        ImageView icon3 = new ImageView(this);
                        icon3.setBackgroundResource(R.drawable.ic_delete_foreground);
                        icon3.setLayoutParams(new TableRow.LayoutParams(
                                TableRow.LayoutParams.FILL_PARENT,
                                TableRow.LayoutParams.WRAP_CONTENT
                        ));
                        icon3.getLayoutParams().height=100;
                        icon3.getLayoutParams().width=100;
                        icon3.setVisibility(View.VISIBLE);
                        icon3.setOnClickListener(new Delete(idCata));
                        trTD.addView(icon3);
                    }

                    trTD.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View v) {
                            Intent intent = new Intent(getApplicationContext(),Cata.class);
                            intent.putExtra("idUsuario",idUsuario);
                            intent.putExtra("idCata",idCata);
                            startActivity(intent);
                        }
                    });

                    table.addView(trTD);
                }
            } else {
                TableRow trTH = new TableRow(this);

                trTH.setGravity(Gravity.CENTER);

                trTH.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT));

                trTH.setVisibility(View.VISIBLE);

                TextView tv = new TextView(this);
                tv.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tv.setGravity(Gravity.CENTER);
                tv.setVisibility(View.VISIBLE);
                tv.setTextSize(20);
                tv.setText(R.string.empty_beer_tasting);
                trTH.addView(tv);
                table.addView(trTH);
            }
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }
    }

    private class Delete implements View.OnClickListener {

        public String idCata;

        public Delete(String s){
            this.idCata=s;
        }

        @Override
        public void onClick(View v) {
            android.app.AlertDialog.Builder builder = new AlertDialog.Builder(Mis_Catas.this);
            builder.setCancelable(true);
            builder.setMessage(getResources().getString(R.string.question_delete_cata));
            builder.setPositiveButton(R.string.ok, new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    Map<String,String> params = new LinkedHashMap<>();
                    params.put("id",idCata);
                    try {
                        Connection con = new Connection(Mis_Catas.this,"deleteCata.php",params);
                        while(con.getRes()==null);
                        Log.v("Delete",con.getRes());
                        if(con.getRes().equals("IOException")){
                            OutputStreamWriter outputStreamWriter = null;
                            if(!Arrays.asList(fileList()).contains("requests.txt")) {
                                new File(getFilesDir(), "requests.txt");
                                outputStreamWriter = new OutputStreamWriter(openFileOutput("requests.txt", Context.MODE_PRIVATE));
                            }else {
                                outputStreamWriter = new OutputStreamWriter(openFileOutput("requests.txt", Context.MODE_APPEND));
                            }
                            outputStreamWriter.write("deleteCata.php;"+idCata+"/");
                            outputStreamWriter.close();

                            android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(Mis_Catas.this);
                            builder.setCancelable(true);
                            builder.setTitle(R.string.error_connecting);
                            builder.setMessage(R.string.ioexception_message);
                            builder.show();
                        }else update();
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