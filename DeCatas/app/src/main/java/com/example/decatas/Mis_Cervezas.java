package com.example.decatas;

import android.graphics.Typeface;
import android.os.Build;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;

import java.net.MalformedURLException;
import java.util.LinkedHashMap;
import java.util.Map;

public class Mis_Cervezas extends AppCompatActivity {

    private String idUsuario;
    public TableLayout table;

    @RequiresApi(api = Build.VERSION_CODES.LOLLIPOP)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_mis_cervezas);

        Bundle bundle = getIntent().getExtras();
        idUsuario = bundle.getString("id");

        this.table = (TableLayout)findViewById(R.id.table);

        Map<String,String> params = new LinkedHashMap<>();
        params.put("id",idUsuario);
        try {
            Connection con = new Connection(getApplicationContext(),"getCervezas.php",params);
            while(con.getRes()==null);
            String result = con.getRes();
            if(!result.equals("")){
                table.removeAllViews();

                String[] cervezas = result.split(";");

                if(cervezas.length>0){
                    TableRow trTH = new TableRow(this);

                    trTH.setGravity(Gravity.CENTER);

                    trTH.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT));

                    trTH.setVisibility(View.VISIBLE);
                    trTH.setBackgroundResource(R.drawable.border);
                    trTH.setPadding(10,10,10,10);

                    int[] labels = {R.string.name,R.string.aroma,R.string.apariencia,R.string.sabor,R.string.cuerpo,R.string.botellin};
                    int i=0;

                    TextView[] rowTextView1 = new TextView[6];
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
                        tv.setTextSize(20);
                        tv.setText(labels[i]);
                        i++;
                        trTH.addView(tv);
                    }

                    table.addView(trTH);

                    for(String c : cervezas){
                        String[] atribs = c.split(",");
                        if(atribs.length>1){
                            String nombre = atribs[0];
                            String aroma = atribs[1];
                            String apariencia = atribs[2];
                            String sabor = atribs[3];
                            String cuerpo = atribs[4];
                            String botellin = atribs[5];

                            TableRow trTD = new TableRow(this);

                            trTD.setGravity(Gravity.CENTER);
                            trTD.setLayoutParams(new TableRow.LayoutParams(
                                    TableRow.LayoutParams.FILL_PARENT,
                                    TableRow.LayoutParams.WRAP_CONTENT));

                            trTD.setVisibility(View.VISIBLE);
                            trTD.setBackgroundResource(R.drawable.tables);

                            TextView[] rowTextView2 = new TextView[6];

                            String[] labelS = {nombre,aroma,apariencia,sabor,cuerpo,botellin};
                            int j=0;

                            for(TextView tv : rowTextView2){
                                tv = new TextView(this);
                                tv.setLayoutParams(new TableRow.LayoutParams(
                                        TableRow.LayoutParams.FILL_PARENT,
                                        TableRow.LayoutParams.WRAP_CONTENT
                                ));
                                tv.setGravity(Gravity.CENTER);
                                tv.setPadding(10,10,10,10);
                                tv.setTextSize(20);
                                tv.setVisibility(View.VISIBLE);
                                tv.setText(labelS[j]);
                                j++;
                                trTD.addView(tv);
                            }
                            table.addView(trTD);
                        }
                    }
                }
            }else{
                TableRow trTH = new TableRow(this);

                trTH.setGravity(Gravity.CENTER);

                trTH.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT));

                trTH.setVisibility(View.VISIBLE);
                trTH.setPadding(10,10,10,10);

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
                trTH.addView(tv);
                table.addView(trTH);
            }
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }
    }
}