package com.example.decatas;

import android.content.Intent;
import android.graphics.Typeface;
import android.os.Bundle;

import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.snackbar.Snackbar;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.view.Gravity;
import android.view.View;
import android.widget.ImageView;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;

import java.net.MalformedURLException;
import java.util.LinkedHashMap;
import java.util.Map;

public class Mis_Amigos extends AppCompatActivity {

    private String idUsuario;
    public TableLayout table;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_mis__amigos);

        Bundle bundle = getIntent().getExtras();
        idUsuario = bundle.getString("id");

        String result = "";

        this.table = (TableLayout)findViewById(R.id.table);

        Map<String,String> params = new LinkedHashMap<>();
        params.put("id",idUsuario);
        try {
            Connection c = new Connection(this,"getAmigos.php",params);
            while (c.getRes()==null);
            result = c.getRes();
        } catch (MalformedURLException e) {
            e.printStackTrace();
        }

        if(result.equals("")){
            TableRow tr = new TableRow(this);

            tr.setGravity(Gravity.CENTER);
            tr.setPadding(10,10,10,10);

            tr.setLayoutParams(new TableRow.LayoutParams(
                    TableRow.LayoutParams.FILL_PARENT,
                    TableRow.LayoutParams.WRAP_CONTENT));

            tr.setVisibility(View.VISIBLE);

            TextView tv = new TextView(this);
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
                tv.setText(R.string.no_friends);
                tr.addView(tv);

            table.addView(tr);
        } else {
            TableRow trTH = new TableRow(this);

            trTH.setGravity(Gravity.CENTER);
            trTH.setBackgroundResource(R.drawable.border);
            trTH.setPadding(10,10,10,10);

            trTH.setLayoutParams(new TableRow.LayoutParams(
                    TableRow.LayoutParams.FILL_PARENT,
                    TableRow.LayoutParams.WRAP_CONTENT));

            trTH.setVisibility(View.VISIBLE);

            int[] labels = {R.string.name,R.string.user};
            int i=0;

            TextView[] rowTextView1 = new TextView[2];
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
            icon1.setBackgroundResource(R.drawable.ic_beer_testing_foreground);
            icon1.setLayoutParams(new TableRow.LayoutParams(
                    TableRow.LayoutParams.FILL_PARENT,
                    TableRow.LayoutParams.WRAP_CONTENT
            ));
            icon1.getLayoutParams().height=100;
            icon1.getLayoutParams().width=100;
            icon1.setVisibility(View.VISIBLE);
            trTH.addView(icon1);

            icon1 = new ImageView(this);
            icon1.setBackgroundResource(R.drawable.ic_beer_foreground);
            icon1.setLayoutParams(new TableRow.LayoutParams(
                    TableRow.LayoutParams.FILL_PARENT,
                    TableRow.LayoutParams.WRAP_CONTENT
            ));
            icon1.getLayoutParams().height=100;
            icon1.getLayoutParams().width=100;
            icon1.setVisibility(View.VISIBLE);
            trTH.addView(icon1);

            icon1 = new ImageView(this);
            icon1.setBackgroundResource(R.drawable.ic_friends_foreground);
            icon1.setLayoutParams(new TableRow.LayoutParams(
                    TableRow.LayoutParams.FILL_PARENT,
                    TableRow.LayoutParams.WRAP_CONTENT
            ));
            icon1.getLayoutParams().height=100;
            icon1.getLayoutParams().width=100;
            icon1.setVisibility(View.VISIBLE);
            trTH.addView(icon1);

            table.addView(trTH);

            String[] friends = result.split(";");
            for (String f : friends){
                String[] infoFriend = f.split(",");
                String usuario = infoFriend[0];
                String nombre = infoFriend[1];
                String nCatas = infoFriend[2];
                String nCervezas = infoFriend[3];
                String nAmigos = infoFriend[4];

                TableRow tr = new TableRow(this);

                tr.setGravity(Gravity.CENTER);
                tr.setBackgroundResource(R.drawable.tables);
                tr.setPadding(10,10,10,10);

                tr.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT));

                tr.setVisibility(View.VISIBLE);

                String[] labels2 = {nombre,usuario,nCatas,nCervezas,nAmigos};
                i=0;

                rowTextView1 = new TextView[5];
                for(TextView tv : rowTextView1){
                    tv = new TextView(this);
                    tv.setLayoutParams(new TableRow.LayoutParams(
                            TableRow.LayoutParams.FILL_PARENT,
                            TableRow.LayoutParams.WRAP_CONTENT
                    ));
                    tv.setGravity(Gravity.CENTER);
                    tv.setVisibility(View.VISIBLE);
                    tv.setPadding(10,10,10,10);
                    tv.setTextSize(17);
                    tv.setText(labels2[i]);
                    i++;
                    tr.addView(tv);
                }

                table.addView(tr);
            }
        }
    }

    public void addFriend(View v){
        Intent intent = new Intent(getApplicationContext(),Anyadir_Amigo.class);
        intent.putExtra("id", idUsuario);
        startActivity(intent);
    }
}