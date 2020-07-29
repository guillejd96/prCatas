package com.example.decatas;

import android.app.AlertDialog;
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
import android.widget.Button;
import android.widget.EditText;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

import java.net.MalformedURLException;
import java.util.LinkedHashMap;
import java.util.Map;

public class Buscar_Cata extends AppCompatActivity {

    private String idUsuario;
    public EditText inputName;
    public TableLayout table;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_buscar__cata);

        Bundle bundle = getIntent().getExtras();
        idUsuario = bundle.getString("id");

        inputName = (EditText)findViewById(R.id.editTextNombreCata);
        table = (TableLayout)findViewById(R.id.table);
    }

    public void search(View v) throws MalformedURLException {
        table.removeAllViews();
        inputName.setBackgroundResource(R.drawable.input_normal);

        String name = inputName.getText().toString();

        if(name.equals("")){
            Toast.makeText(this, "Introduce un nombre de cata", Toast.LENGTH_LONG).show();
            inputName.setBackgroundResource(R.drawable.input_error);
            return;
        }

        Map<String,String> params = new LinkedHashMap<>();
        params.put("n",name);
        Connection con = new Connection(this,"getCatasByName.php",params);
        while (con.getRes()==null);
        String result = con.getRes();
        if(result.equals("")){
            Toast.makeText(this, "No se han encontrado coincidencias", Toast.LENGTH_LONG).show();
        }else {
            String[] aux = result.split(";");
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
            tv.setPadding(10,10,10,10);
            tv.setTextSize(15);
            tv.setText(R.string.name);
            trTH.addView(tv);
            for(String c : aux){
                String[] cer = c.split(",");
                String idCata = cer[0];
                String nombreCata = cer[1];
                TableRow trTD = new TableRow(this);
                trTD.setGravity(Gravity.CENTER);
                trTD.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT));
                trTD.setVisibility(View.VISIBLE);
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
                tv.setText(nombreCata);
                trTD.addView(tv);

                Button btn = new Button(this);
                btn.setLayoutParams(new TableRow.LayoutParams(
                        TableRow.LayoutParams.FILL_PARENT,
                        TableRow.LayoutParams.WRAP_CONTENT
                ));
                btn.setGravity(Gravity.CENTER);
                btn.setVisibility(View.VISIBLE);
                btn.setPadding(10,10,10,10);
                btn.setTextSize(20);
                btn.setText("+");
                btn.setTag(idCata);
                btn.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {
                        String id = (String) v.getTag();
                        try {
                            join(id);
                        } catch (MalformedURLException e) {
                            e.printStackTrace();
                        }
                    }
                });
                trTD.addView(btn);

                table.addView(trTD);
            }
        }
    }

    private void join(final String id) throws MalformedURLException {
        final String[] aux = new String[1];
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setTitle("Introduce la contraseña de la cata");

        final EditText input = new EditText(this);
        input.setInputType(InputType.TYPE_TEXT_VARIATION_PASSWORD);
        builder.setView(input);

        builder.setPositiveButton("OK", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                aux[0] = input.getText().toString();
                Log.v("join",aux[0]);
                Map<String,String> params = new LinkedHashMap<>();
                params.put("u",idUsuario);
                params.put("c",id);
                params.put("p",aux[0]);
                Connection con = null;
                try {
                    con = new Connection(getApplicationContext(),"joinCata.php",params);
                } catch (MalformedURLException e) {
                    e.printStackTrace();
                }
                while (con.getRes()==null);
                String result = con.getRes();
                if(result.equals("1")){
                    Intent intent = new Intent(getApplicationContext(),Cata.class);
                    intent.putExtra("idUsuario",idUsuario);
                    intent.putExtra("idCata",id);
                    startActivity(intent);
                }else {
                    Toast.makeText(getApplicationContext(), "No se ha podido unir a la cata", Toast.LENGTH_LONG).show();
                }

            }
        });
        builder.setNegativeButton("Cancel", new DialogInterface.OnClickListener() {
            @Override
            public void onClick(DialogInterface dialog, int which) {
                dialog.cancel();
            }
        });

        builder.show();



    }
}