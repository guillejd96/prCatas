package com.example.decatas;

import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.ImageView;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;

import java.net.MalformedURLException;
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

                trTH.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT));

                trTH.setVisibility(View.VISIBLE);

                int[] labels = {R.string.name,R.string.date, R.string.en_curso,R.string.admin};
                int i=0;

                TextView[] rowTextView1 = new TextView[4];
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
                    tv.setTextSize(15);
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
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTD.setVisibility(View.VISIBLE);

                    TextView[] rowTextView2 = new TextView[6];

                    Log.v("Mis catas",en_cursoCata);
                    String en_curso = en_cursoCata.equals("1") ? "Sí" : "No";

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

                    if(idUsuario.equals(idAdminCata)){
                        admin = "Tú";
                    }else {
                        Map<String,String> params4 = new LinkedHashMap<>();
                        params4.put("id",idAdminCata);
                        Connection conn3 = new Connection(this,"getAdmin.php",params4);
                        while (conn3.getRes()==null);
                        String[] result2 = conn.getRes().split(",");
                        admin=result2[0]+"("+result2[1]+")";
                    }

                    String[] labelS = {nombreCata,fechaCata,en_curso,admin,nPersonas,nCervezas};
                    int j=0;

                    for(TextView tv : rowTextView2){
                        tv = new TextView(this);
                        tv.setLayoutParams(new TableRow.LayoutParams(
                                TableRow.LayoutParams.FILL_PARENT,
                                TableRow.LayoutParams.WRAP_CONTENT
                        ));
                        tv.setGravity(Gravity.CENTER);
                        tv.setPadding(10,10,10,10);
                        tv.setTextSize(15);
                        tv.setVisibility(View.VISIBLE);
                        tv.setText(labelS[j]);
                        j++;
                        trTD.addView(tv);
                    }

                    if(en_cursoCata.equals("1")){
                        trTD.setOnClickListener(new View.OnClickListener() {
                            @Override
                            public void onClick(View v) {
                                Intent intent = new Intent(getApplicationContext(),Cata.class);
                                intent.putExtra("idUsuario",idUsuario);
                                intent.putExtra("idCata",idCata);
                                startActivity(intent);
                            }
                        });
                    }
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
                    tv.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
                    tv.setGravity(Gravity.CENTER);
                    tv.setVisibility(View.VISIBLE);
                    tv.setTextSize(20);
                    tv.setText("No te has unido a ninguna cata");
                    trTH.addView(tv);
                table.addView(trTH);
            }
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }
    }
}