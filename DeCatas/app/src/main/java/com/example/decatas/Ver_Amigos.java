package com.example.decatas;

import android.graphics.Paint;
import android.graphics.Typeface;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TableRow;
import android.widget.TextView;

import java.net.MalformedURLException;
import java.util.LinkedHashMap;
import java.util.Map;

public class Ver_Amigos extends AppCompatActivity {

    private String idUsuario,idAmigo;
    public TextView title;
    public LinearLayout layout;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_ver__amigos);

        Bundle bundle = getIntent().getExtras();
        idUsuario = bundle.getString("idU");
        idAmigo = bundle.getString("idA");

        Log.v("Ver Amigos",idAmigo);

        title = (TextView)findViewById(R.id.title);
        layout = (LinearLayout)findViewById(R.id.layout);

        Map<String,String> params = new LinkedHashMap<>();
        params.put("id",idAmigo);
        Connection c = null;
        try {
            c = new Connection(this,"getAmigo.php",params);
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }
        while(c.getRes()==null);
        String result = c.getRes();

        String[] infoResult = result.split("/");

        String title = infoResult[0];
        String[] infoTitle = title.split(",");

        String usuario = infoTitle[0];
        String nombre = infoTitle[1];
        String nCervezas = infoTitle[2];
        String nCatas = infoTitle[2];
        String nAmigos = infoTitle[3];

        this.title.setText(nombre+" ("+usuario+")");

        TextView tv = new TextView(this);
        tv.setLayoutParams(new TableRow.LayoutParams(
                TableRow.LayoutParams.FILL_PARENT,
                TableRow.LayoutParams.WRAP_CONTENT
        ));
        tv.setGravity(Gravity.CENTER);
        tv.setVisibility(View.VISIBLE);
        tv.setPadding(10, 20, 10, 10);
        tv.setTextSize(22);
        tv.setText(getResources().getString(R.string.number_of)+" "+getResources().getString(R.string.label_beers_friend)+" "+nCervezas);

        layout.addView(tv);

        tv = new TextView(this);
        tv.setLayoutParams(new TableRow.LayoutParams(
                TableRow.LayoutParams.FILL_PARENT,
                TableRow.LayoutParams.WRAP_CONTENT
        ));
        tv.setGravity(Gravity.CENTER);
        tv.setVisibility(View.VISIBLE);
        tv.setPadding(10, 20, 10, 10);
        tv.setTextSize(22);
        tv.setText(getResources().getString(R.string.number_of)+" "+getResources().getString(R.string.label_beer_tasting_friends)+" "+nCatas);

        layout.addView(tv);

        tv = new TextView(this);
        tv.setLayoutParams(new TableRow.LayoutParams(
                TableRow.LayoutParams.FILL_PARENT,
                TableRow.LayoutParams.WRAP_CONTENT
        ));
        tv.setGravity(Gravity.CENTER);
        tv.setVisibility(View.VISIBLE);
        tv.setPadding(10, 20, 10, 10);
        tv.setTextSize(22);
        tv.setText(getResources().getString(R.string.number_of)+" "+getResources().getString(R.string.label_friends_friend)+" "+nAmigos);

        layout.addView(tv);

        if(Integer.parseInt(nCervezas)>0){
            tv = new TextView(this);
            tv.setLayoutParams(new TableRow.LayoutParams(
                    TableRow.LayoutParams.FILL_PARENT,
                    TableRow.LayoutParams.WRAP_CONTENT
            ));
            tv.setTypeface(Typeface.DEFAULT,Typeface.BOLD);
            tv.setGravity(Gravity.CENTER);
            tv.setVisibility(View.VISIBLE);
            tv.setPadding(10, 20, 10, 10);
            tv.setTextSize(22);
            tv.setPaintFlags(tv.getPaintFlags() | Paint.UNDERLINE_TEXT_FLAG);
            tv.setText(R.string.beers);

            layout.addView(tv);

            String infoCervezas = infoResult[1];
            String[] cervezas = infoCervezas.split(";");
            for(String b : cervezas){
                String[] infoCerveza = b.split(",");

                String nombreCerveza = infoCerveza[0];
                String aroma = infoCerveza[1];
                String apariencia = infoCerveza[2];
                String sabor = infoCerveza[3];
                String cuerpo = infoCerveza[4];
                String botellin = infoCerveza[4];

                tv = new TextView(this);
                tv.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tv.setTypeface(Typeface.DEFAULT,Typeface.BOLD);
                tv.setGravity(Gravity.CENTER);
                tv.setVisibility(View.VISIBLE);
                tv.setPadding(10, 20, 10, 10);
                tv.setTextSize(20);
                tv.setText(nombreCerveza);

                layout.addView(tv);

                tv = new TextView(this);
                tv.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tv.setGravity(Gravity.CENTER);
                tv.setVisibility(View.VISIBLE);
                tv.setPadding(10, 20, 10, 10);
                tv.setTextSize(20);
                tv.setText(getResources().getString(R.string.label_smell)+" "+aroma);

                layout.addView(tv);

                tv = new TextView(this);
                tv.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tv.setGravity(Gravity.CENTER);
                tv.setVisibility(View.VISIBLE);
                tv.setPadding(10, 20, 10, 10);
                tv.setTextSize(20);
                tv.setText(getResources().getString(R.string.label_appearance)+" "+apariencia);

                layout.addView(tv);

                tv = new TextView(this);
                tv.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tv.setGravity(Gravity.CENTER);
                tv.setVisibility(View.VISIBLE);
                tv.setPadding(10, 20, 10, 10);
                tv.setTextSize(20);
                tv.setText(getResources().getString(R.string.label_taste)+" "+sabor);

                layout.addView(tv);

                tv = new TextView(this);
                tv.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tv.setGravity(Gravity.CENTER);
                tv.setVisibility(View.VISIBLE);
                tv.setPadding(10, 20, 10, 10);
                tv.setTextSize(20);
                tv.setText(getResources().getString(R.string.label_body)+" "+cuerpo);

                layout.addView(tv);

                tv = new TextView(this);
                tv.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                tv.setGravity(Gravity.CENTER);
                tv.setVisibility(View.VISIBLE);
                tv.setPadding(10, 20, 10, 10);
                tv.setTextSize(20);
                tv.setText(getResources().getString(R.string.label_bottle)+" "+botellin);

                layout.addView(tv);

            }
        }

        tv = new TextView(this);
        tv.setLayoutParams(new TableRow.LayoutParams(
                TableRow.LayoutParams.FILL_PARENT,
                TableRow.LayoutParams.WRAP_CONTENT
        ));
        tv.setGravity(Gravity.CENTER);
        tv.setVisibility(View.VISIBLE);
        tv.setPadding(10, 20, 10, 10);
        tv.setTextSize(20);
        tv.setText("");

        layout.addView(tv);
    }
}