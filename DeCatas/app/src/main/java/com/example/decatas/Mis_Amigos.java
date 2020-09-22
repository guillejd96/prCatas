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

import android.util.Log;
import android.view.Gravity;
import android.view.View;
import android.widget.ImageView;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;

import org.w3c.dom.Text;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.OutputStreamWriter;
import java.net.MalformedURLException;
import java.util.Arrays;
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

        update();
    }

    public void update(){
        this.table.removeAllViews();
        Map<String,String> params = new LinkedHashMap<>();
        params.put("id",idUsuario);
        String result="";
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

            TextView space = new TextView(this);
            space.setLayoutParams(new TableRow.LayoutParams(
                    TableRow.LayoutParams.FILL_PARENT,
                    TableRow.LayoutParams.WRAP_CONTENT
            ));
            space.setTypeface(Typeface.DEFAULT, Typeface.BOLD);
            space.setGravity(Gravity.CENTER);
            space.setVisibility(View.VISIBLE);
            space.setPadding(10,10,10,10);
            trTH.addView(space);

            table.addView(trTH);

            String[] friends = result.split(";");
            for (String f : friends){
                String[] infoFriend = f.split(",");
                String idAmigo = infoFriend[0];
                String usuario = infoFriend[1];
                String nombre = infoFriend[2];
                String nCatas = infoFriend[3];
                String nCervezas = infoFriend[4];
                String nAmigos = infoFriend[5];

                TableRow tr = new TableRow(this);

                tr.setGravity(Gravity.CENTER);
                tr.setBackgroundResource(R.drawable.tables);
                tr.setPadding(10,10,10,10);

                tr.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT));

                tr.setVisibility(View.VISIBLE);

                Listener l = new Listener(idAmigo);
                tr.setOnClickListener(l);

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

                ImageView deleteIcon = new ImageView(this);
                deleteIcon.setBackgroundResource(R.drawable.ic_delete_foreground);
                deleteIcon.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                deleteIcon.getLayoutParams().height=100;
                deleteIcon.getLayoutParams().width=100;
                deleteIcon.setVisibility(View.VISIBLE);
                deleteIcon.setOnClickListener(new Delete(idAmigo));
                tr.addView(deleteIcon);

                table.addView(tr);
            }
        }
    }

    public void addFriend(View v){
        Intent intent = new Intent(getApplicationContext(),Anyadir_Amigo.class);
        intent.putExtra("id", idUsuario);
        startActivity(intent);
    }

    private class Listener implements View.OnClickListener{

        String idA;

        Listener(String id){
            this.idA=id;
        }

        @Override
        public void onClick(View v) {
            Intent intent = new Intent(getApplicationContext(),Ver_Amigos.class);
            intent.putExtra("idU", idUsuario);
            intent.putExtra("idA", idA);
            startActivity(intent);
        }
    }

    private class Delete implements View.OnClickListener {

        public String idAmigo;

        public Delete(String s){
            this.idAmigo=s;
        }

        @Override
        public void onClick(View v) {
            android.app.AlertDialog.Builder builder = new AlertDialog.Builder(Mis_Amigos.this);
            builder.setCancelable(true);
            builder.setMessage(getResources().getString(R.string.question_delete_cata));
            builder.setPositiveButton(R.string.ok, new DialogInterface.OnClickListener() {
                @Override
                public void onClick(DialogInterface dialog, int which) {
                    Map<String,String> params = new LinkedHashMap<>();
                    params.put("id1",idUsuario);
                    params.put("id2",idAmigo);
                    try {
                        Connection con = new Connection(Mis_Amigos.this,"deleteAmigo.php",params);
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
                            outputStreamWriter.write("deleteAmigo.php;"+idUsuario+","+idAmigo+"/");
                            outputStreamWriter.close();

                            android.app.AlertDialog.Builder builder = new android.app.AlertDialog.Builder(Mis_Amigos.this);
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