package com.example.decatas;

import android.graphics.Paint;
import android.graphics.Typeface;
import android.os.Build;
import android.os.Bundle;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;

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
    public LinearLayout layout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_mis_cervezas);

        Bundle bundle = getIntent().getExtras();
        idUsuario = bundle.getString("id");

        this.layout = (LinearLayout)findViewById(R.id.layout);

        Map<String,String> params = new LinkedHashMap<>();
        params.put("id",idUsuario);
        try {
            Connection con = new Connection(getApplicationContext(),"getCervezas.php",params);
            while(con.getRes()==null);
            String result = con.getRes();
            if(!result.equals("")){
                layout.removeAllViews();

                String[] cervezas = result.split(";");

                if(cervezas.length>0){
                    for(String c : cervezas){
                        String[] atribs = c.split(",");
                        if(atribs.length>1){
                            String nombre = atribs[0];
                            String aroma = atribs[1];
                            String apariencia = atribs[2];
                            String sabor = atribs[3];
                            String cuerpo = atribs[4];
                            String botellin = atribs[5];

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
}